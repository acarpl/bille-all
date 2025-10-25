<?php
// app/models/PackageModel.php

class PackageModel extends Model {
    protected $table = 'packages';
    protected $primaryKey = 'id';
    
    /**
     * Get packages with floor-specific pricing
     */
    public function getAvailablePackagesWithFloorPricing($date, $startTime) {
        $dayOfWeek = strtolower(date('l', strtotime($date)));
        $currentTime = date('H:i:s', strtotime($startTime));
        
        // Get all active packages
        $sql = "SELECT p.* FROM {$this->table} p
                WHERE p.is_active = TRUE
                AND (p.start_time IS NULL OR p.start_time <= ?)
                AND (p.end_time IS NULL OR p.end_time >= ?)
                AND (
                    p.valid_days IS NULL 
                    OR p.valid_days = 'everyday'
                    OR FIND_IN_SET(?, p.valid_days)
                )
                ORDER BY p.display_order ASC, p.price ASC";
        
        $packages = $this->db->fetchAll($sql, [$currentTime, $currentTime, $dayOfWeek]);
        
        // Get all active floors
        $floors = $this->db->fetchAll("SELECT * FROM floors WHERE is_active = TRUE ORDER BY name ASC");
        
        // Attach floor pricing to each package
        foreach ($packages as &$package) {
            $package['floor_pricing'] = $this->getFloorPricingForPackage($package, $floors);
        }
        
        return $packages;
    }
    
    /**
     * Calculate price for each floor based on package rules
     */
    private function getFloorPricingForPackage($package, $floors) {
        $pricing = [];
        
        foreach ($floors as $floor) {
            // Check if package applies to this floor
            if (!$this->packageAppliesTo($package, $floor['id'])) {
                continue;
            }
            
            // Get floor's hourly rate (from the most expensive table on that floor)
            $floorRate = $this->getFloorHourlyRate($floor['id']);
            
            // Calculate price based on package type
            $price = $this->calculatePriceForFloor($package, $floorRate);
            
            $pricing[] = [
                'floor_id' => $floor['id'],
                'floor_name' => $floor['name'],
                'price' => $price,
                'formatted_price' => number_format($price, 0, ',', '.')
            ];
        }
        
        return $pricing;
    }
    
    /**
     * Check if package applies to a specific floor
     */
    private function packageAppliesTo($package, $floorId) {
        if ($package['apply_to'] === 'all_floors') {
            return true;
        }
        
        if ($package['apply_to'] === 'specific_floors' && !empty($package['floor_ids'])) {
            $floorIds = json_decode($package['floor_ids'], true);
            return is_array($floorIds) && in_array($floorId, $floorIds);
        }
        
        if ($package['apply_to'] === 'specific_tables' && !empty($package['table_ids'])) {
            // Check if any table on this floor is in the package
            $tableIds = json_decode($package['table_ids'], true);
            if (!is_array($tableIds) || empty($tableIds)) {
                return false;
            }
            
            $placeholders = implode(',', array_fill(0, count($tableIds), '?'));
            $sql = "SELECT COUNT(*) as count FROM tables 
                    WHERE floor_id = ? AND id IN ($placeholders)";
            $params = array_merge([$floorId], $tableIds);
            $result = $this->db->fetch($sql, $params);
            return $result['count'] > 0;
        }
        
        return true; // Default: apply to all
    }
    
    /**
     * Get the hourly rate for a floor (from most expensive table)
     */
    private function getFloorHourlyRate($floorId) {
        $sql = "SELECT MAX(hourly_rate) as rate FROM tables WHERE floor_id = ? AND is_active = TRUE";
        $result = $this->db->fetch($sql, [$floorId]);
        return $result['rate'] ?? 50000; // Default fallback
    }
    
    /**
     * Calculate price based on package type and floor rate
     */
    private function calculatePriceForFloor($package, $floorRate) {
        switch ($package['package_type']) {
            case 'hourly':
                return $package['price']; // Already per hour
                
            case 'flat_rate':
                return $package['price']; // Fixed price
                
            case 'unlimited':
                return $package['price']; // Fixed unlimited price
                
            default:
                return $floorRate; // Use floor's hourly rate
        }
    }
    
    /**
     * Original method - untuk backward compatibility
     */
    public function getAvailablePackages($date, $startTime, $tableId = null) {
        $dayOfWeek = strtolower(date('l', strtotime($date)));
        $currentTime = date('H:i:s', strtotime($startTime));
        
        $sql = "SELECT p.* FROM {$this->table} p
                WHERE p.is_active = TRUE
                AND (p.start_time IS NULL OR p.start_time <= ?)
                AND (p.end_time IS NULL OR p.end_time >= ?)
                AND (
                    p.valid_days IS NULL 
                    OR p.valid_days = 'everyday'
                    OR FIND_IN_SET(?, p.valid_days)
                )";
        
        $params = [$currentTime, $currentTime, $dayOfWeek];
        
        if ($tableId !== null) {
            $sql .= " AND (
                p.apply_to = 'all_floors'
                OR (p.apply_to = 'specific_floors' AND JSON_CONTAINS(p.floor_ids, JSON_ARRAY((SELECT floor_id FROM tables WHERE id = ?))))
                OR (p.apply_to = 'specific_tables' AND JSON_CONTAINS(p.table_ids, JSON_ARRAY(?)))
            )";
            $params[] = $tableId;
            $params[] = $tableId;
        }
        
        $sql .= " ORDER BY p.price ASC";
        
        return $this->db->fetchAll($sql, $params);
    }
    
    public function calculatePackagePrice($packageId, $durationHours, $tableHourlyRate) {
        $package = $this->find($packageId);
        
        if (!$package) return 0;
        
        switch ($package['package_type']) {
            case 'hourly':
                return $package['price'] * $durationHours;
                
            case 'flat_rate':
                return $package['price'];
                
            case 'unlimited':
                return $package['price'];
                
            default:
                return $tableHourlyRate * $durationHours;
        }
    }
    
    public function getPackageConditions($packageId) {
        $package = $this->find($packageId);
        return $package['conditions'] ?? null;
    }
}
?>