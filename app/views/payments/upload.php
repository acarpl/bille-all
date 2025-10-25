<div style="padding: 2rem 0;">
        <!-- Navigation -->
        <div style="margin-bottom: 2rem;">
            <a href="<?= Router::url('payment/instructions/' . $data['payment']['id']) ?>" 
               style="display: inline-flex; align-items: center; gap: 0.5rem; 
                      color: var(--text-muted); font-weight: 600; text-decoration: none;">
                ← Back to Payment Instructions
            </a>
        </div>

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                📎 Upload Payment Proof
            </h1>
            <p style="color: var(--text-muted); font-weight: 500;">
                Upload your payment receipt for verification
            </p>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['payment_success'])): ?>
            <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid rgba(46, 204, 113, 0.3); 
                        padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <div style="color: #2ecc71; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    ✅ <?= $_SESSION['payment_success'] ?>
                </div>
            </div>
            <?php unset($_SESSION['payment_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['payment_error'])): ?>
            <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid rgba(231, 76, 60, 0.3); 
                        padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <div style="color: #e74c3c; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    ❌ <?= $_SESSION['payment_error'] ?>
                </div>
            </div>
            <?php unset($_SESSION['payment_error']); ?>
        <?php endif; ?>

        <div style="max-width: 600px; margin: 0 auto;">
            <div class="card">
                <!-- Payment Summary -->
                <div style="text-align: center; margin-bottom: 2rem; padding-bottom: 2rem; 
                           border-bottom: 1px solid var(--border-color);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💰</div>
                    <h2 style="font-weight: 800; margin-bottom: 0.5rem;">
                        <?= htmlspecialchars($data['payment']['tournament_name']) ?>
                    </h2>
                    <div style="color: var(--text-muted); margin-bottom: 1rem;">
                        Team: <strong><?= htmlspecialchars($data['payment']['team_name']) ?></strong>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--accent);">
                        Rp <?= number_format($data['payment']['amount'], 0, ',', '.') ?>
                    </div>
                </div>

                <!-- Upload Form -->
                <form id="uploadForm" enctype="multipart/form-data">
                    <input type="hidden" name="payment_id" value="<?= $data['payment']['id'] ?>">
                    
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-weight: 700; margin-bottom: 1rem;">Upload Payment Proof</h3>
                        
                        <!-- File Upload Area -->
                        <div id="uploadArea" 
                             style="border: 2px dashed var(--border-color); border-radius: 12px; 
                                    padding: 3rem 2rem; text-align: center; cursor: pointer;
                                    transition: all 0.3s ease; margin-bottom: 1rem;">
                            <div style="font-size: 4rem; margin-bottom: 1rem;">📁</div>
                            <div style="font-weight: 600; margin-bottom: 0.5rem;">
                                Click to upload or drag and drop
                            </div>
                            <div style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">
                                PNG, JPG, JPEG files (Max 2MB)
                            </div>
                            <input type="file" id="payment_proof" name="payment_proof" 
                                   accept=".jpg,.jpeg,.png,.pdf" style="display: none;">
                            <div id="fileName" style="font-weight: 600; color: var(--accent);"></div>
                        </div>

                        <!-- Preview Image -->
                        <div id="previewContainer" style="display: none; margin-bottom: 1rem;">
                            <div style="font-weight: 600; margin-bottom: 0.5rem;">Preview:</div>
                            <img id="previewImage" src="" alt="Preview" 
                                 style="max-width: 100%; max-height: 300px; border-radius: 8px; 
                                        border: 1px solid var(--border-color);">
                        </div>

                        <!-- Upload Progress -->
                        <div id="progressContainer" style="display: none; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: between; margin-bottom: 0.5rem;">
                                <span>Uploading...</span>
                                <span id="progressPercent">0%</span>
                            </div>
                            <div style="background: var(--bg-secondary); height: 6px; border-radius: 3px; overflow: hidden;">
                                <div id="progressBar" style="background: var(--accent); height: 100%; width: 0%; 
                                                           transition: width 0.3s ease;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-weight: 700; margin-bottom: 1rem;">Additional Information</h3>
                        
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Sender Name (if different)
                            </label>
                            <input type="text" id="sender_name" name="sender_name"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                          border-radius: 8px; font-size: 1rem;"
                                   placeholder="Name as shown in bank transfer">
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Transfer Date & Time
                            </label>
                            <input type="datetime-local" id="transfer_date" name="transfer_date"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                          border-radius: 8px; font-size: 1rem;">
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Additional Notes (Optional)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); 
                                             border-radius: 8px; font-size: 1rem; resize: vertical;"
                                      placeholder="Any additional information about your payment..."></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                            style="width: 100%; padding: 1rem; background: var(--accent); color: white; 
                                   border: none; border-radius: 8px; font-weight: 700; font-size: 1.1rem; 
                                   cursor: pointer; transition: background 0.3s ease;">
                        📤 Submit Payment Proof
                    </button>
                </form>

                <!-- Upload Guidelines -->
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                    <h3 style="font-weight: 700; margin-bottom: 1rem;">📋 Upload Guidelines</h3>
                    
                    <div style="display: grid; gap: 1rem;">
                        <div style="display: flex; gap: 1rem;">
                            <div style="color: #27ae60; font-weight: 700;">✅</div>
                            <div>
                                <div style="font-weight: 600;">Clear and Readable</div>
                                <div style="font-size: 0.9rem; color: var(--text-muted);">
                                    Ensure all text is clearly visible
                                </div>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 1rem;">
                            <div style="color: #27ae60; font-weight: 700;">✅</div>
                            <div>
                                <div style="font-weight: 600;">Complete Information</div>
                                <div style="font-size: 0.9rem; color: var(--text-muted);">
                                    Show sender name, amount, and date
                                </div>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 1rem;">
                            <div style="color: #e74c3c; font-weight: 700;">❌</div>
                            <div>
                                <div style="font-weight: 600;">No Blurry Images</div>
                                <div style="font-size: 0.9rem; color: var(--text-muted);">
                                    Avoid blurry or dark photos
                                </div>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 1rem;">
                            <div style="color: #e74c3c; font-weight: 700;">❌</div>
                            <div>
                                <div style="font-weight: 600;">No Screenshots of Apps</div>
                                <div style="font-size: 0.9rem; color: var(--text-muted);">
                                    Upload actual receipt, not app screenshots
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Information -->
            <div class="card" style="margin-top: 2rem; text-align: center;">
                <h3 style="font-weight: 700; margin-bottom: 1rem;">Need Help?</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
                    If you're having trouble with the upload process, contact our support team.
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="https://wa.me/6281234567890" target="_blank" 
                       style="padding: 0.75rem 1.5rem; background: #25D366; color: white; 
                              border-radius: 8px; text-decoration: none; font-weight: 600;">
                        📱 WhatsApp Support
                    </a>
                    <a href="mailto:support@billesouthside.com" 
                       style="padding: 0.75rem 1.5rem; background: var(--bg-secondary); 
                              border-radius: 8px; text-decoration: none; font-weight: 600;">
                        ✉️ Email Support
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('payment_proof');
            const fileName = document.getElementById('fileName');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressPercent = document.getElementById('progressPercent');
            const submitBtn = document.getElementById('submitBtn');
            const uploadForm = document.getElementById('uploadForm');

            // File upload handling
            uploadArea.addEventListener('click', () => fileInput.click());
            
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = 'var(--accent)';
                uploadArea.style.background = 'rgba( var(--accent-rgb), 0.05)';
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.style.borderColor = 'var(--border-color)';
                uploadArea.style.background = 'transparent';
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.style.borderColor = 'var(--border-color)';
                uploadArea.style.background = 'transparent';
                
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    handleFileSelect(e.dataTransfer.files[0]);
                }
            });

            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length) {
                    handleFileSelect(e.target.files[0]);
                }
            });

            function handleFileSelect(file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!validTypes.includes(file.type)) {
                    alert('Please upload only JPG, PNG, or PDF files.');
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    return;
                }

                fileName.textContent = file.name;
                
                // Show preview for images
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                }
            }

            // Form submission with AJAX
            uploadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!fileInput.files.length) {
                    alert('Please select a file to upload.');
                    return;
                }

                const formData = new FormData(this);
                
                // Show progress
                progressContainer.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.textContent = 'Uploading...';
                submitBtn.style.background = '#95a5a6';

                // Simulate upload progress (in real app, use XMLHttpRequest with progress event)
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += 5;
                    progressBar.style.width = progress + '%';
                    progressPercent.textContent = progress + '%';
                    
                    if (progress >= 100) {
                        clearInterval(progressInterval);
                        // Actual AJAX request would go here
                        simulateAjaxUpload(formData);
                    }
                }, 100);
            });

            function simulateAjaxUpload(formData) {
                // This would be your actual AJAX call
                fetch('<?= Router::url("payment/upload-proof") ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to success page or show success message
                        window.location.href = '<?= Router::url("payment/instructions/' . $data['payment']['id'] . '") ?>';
                    } else {
                        alert(data.error || 'Upload failed. Please try again.');
                        resetForm();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Upload failed. Please try again.');
                    resetForm();
                });
            }

            function resetForm() {
                progressContainer.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.textContent = '📤 Submit Payment Proof';
                submitBtn.style.background = 'var(--accent)';
                progressBar.style.width = '0%';
                progressPercent.textContent = '0%';
            }
        });
    </script>