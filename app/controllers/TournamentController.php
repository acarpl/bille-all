<?php
class TournamentController extends Controller {
    private $tournamentModel;
    
    public function __construct() {
        parent::__construct();
        $this->tournamentModel = new TournamentModel();
    }
    
    public function index() {
        $upcomingTournaments = $this->tournamentModel->getUpcomingTournaments();
        $activeTournaments = $this->tournamentModel->getActiveTournaments();
        
        $data = [
            'title' => 'Tournaments & Events',
            'current_route' => 'tournaments',
            'upcomingTournaments' => $upcomingTournaments,
            'activeTournaments' => $activeTournaments
        ];
        
        $this->view('tournaments/index', $data);
    }
    
    public function show($id) {
        // Handle parameter (bisa string atau array)
        if (is_array($id)) {
            $id = $id[0];
        }
        
        $tournament = $this->tournamentModel->getTournamentById($id);
        
        if (!$tournament) {
            $_SESSION['tournament_error'] = 'Tournament not found';
            $this->redirect('tournaments');
            return;
        }
        
        $isRegistered = false;
        if (Auth::check()) {
            $isRegistered = $this->tournamentModel->isUserRegistered($id, Auth::id());
        }
        
        $registrations = $this->tournamentModel->getTournamentRegistrations($id);
        
        $data = [
            'title' => $tournament['name'],
            'current_route' => 'tournaments',
            'tournament' => $tournament,
            'isRegistered' => $isRegistered,
            'registrations' => $registrations
        ];
        
        $this->view('tournaments/view', $data);
    }
    
    // ✅ TAMBAHKAN METHOD INI - untuk halaman form register
    public function registerPage($id) {
        $this->requireAuth();
        
        if (is_array($id)) {
            $id = $id[0];
        }
        
        $tournament = $this->tournamentModel->getTournamentById($id);
        
        if (!$tournament) {
            $_SESSION['tournament_error'] = 'Tournament not found';
            $this->redirect('tournaments');
            return;
        }
        
        // Cek apakah user sudah terdaftar
        if ($this->tournamentModel->isUserRegistered($id, Auth::id())) {
            $_SESSION['tournament_error'] = 'You are already registered for this tournament';
            $this->redirect('tournaments/view/' . $id);
            return;
        }
        
        // Cek deadline registrasi
        if (strtotime($tournament['registration_deadline']) < time()) {
            $_SESSION['tournament_error'] = 'Registration deadline has passed';
            $this->redirect('tournaments/view/' . $id);
            return;
        }
        
        // Cek apakah tournament penuh
        $currentParticipants = $this->tournamentModel->countTournamentRegistrations($id);
        if ($currentParticipants >= $tournament['max_participants']) {
            $_SESSION['tournament_error'] = 'Tournament is already full';
            $this->redirect('tournaments/view/' . $id);
            return;
        }
        
        $data = [
            'title' => 'Register for ' . $tournament['name'],
            'current_route' => 'tournaments',
            'tournament' => $tournament,
            'current_participants' => $currentParticipants
        ];
        
        $this->view('tournaments/register', $data);
    }
    
    public function register() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['tournament_error'] = 'Invalid request method';
            $this->redirect('tournaments');
            return;
        }
        
        $tournamentId = $_POST['tournament_id'] ?? null;
        $teamName = $_POST['team_name'] ?? '';
        $playerCount = $_POST['player_count'] ?? 1;
        $terms = isset($_POST['terms']);
        
        // Validasi input
        if (empty($tournamentId) || empty($teamName)) {
            $_SESSION['tournament_error'] = 'Team name is required';
            $this->redirect('tournaments/register/' . $tournamentId);
            return;
        }
        
        // Validasi terms
        if (!$terms) {
            $_SESSION['tournament_error'] = 'You must agree to the tournament terms and conditions';
            $this->redirect('tournaments/register/' . $tournamentId);
            return;
        }
        
        // Validasi player count
        $playerCount = max(1, min(10, intval($playerCount)));
        
        // Cek apakah user sudah terdaftar
        if ($this->tournamentModel->isUserRegistered($tournamentId, Auth::id())) {
            $_SESSION['tournament_error'] = 'You are already registered for this tournament';
            $this->redirect('tournaments/view/' . $tournamentId);
            return;
        }
        
        // Cek apakah tournament ada
        $tournament = $this->tournamentModel->getTournamentById($tournamentId);
        if (!$tournament) {
            $_SESSION['tournament_error'] = 'Tournament not found';
            $this->redirect('tournaments');
            return;
        }
        
        // Cek deadline registrasi
        if (strtotime($tournament['registration_deadline']) < time()) {
            $_SESSION['tournament_error'] = 'Registration deadline has passed';
            $this->redirect('tournaments/view/' . $tournamentId);
            return;
        }
        
        // Cek apakah tournament penuh
        $currentParticipants = $this->tournamentModel->countTournamentRegistrations($tournamentId);
        if ($currentParticipants >= $tournament['max_participants']) {
            $_SESSION['tournament_error'] = 'Tournament is already full';
            $this->redirect('tournaments/view/' . $tournamentId);
            return;
        }
        
        // Daftarkan player
        if ($this->tournamentModel->registerPlayer($tournamentId, Auth::id(), $teamName, $playerCount)) {
            $_SESSION['tournament_success'] = '🎉 Successfully registered for ' . $tournament['name'] . '! Team: ' . $teamName . ' (' . $playerCount . ' player' . ($playerCount > 1 ? 's' : '') . '). Good luck! 🏆';
            
            // ✅ OPSI 1: Redirect ke halaman detail tournament
            $this->redirect('tournaments/view/' . $tournamentId);
        } else {
            $_SESSION['tournament_error'] = '❌ Failed to register for the tournament. Please try again.';
            $this->redirect('tournaments/register/' . $tournamentId);
        }
    }
    
    public function myRegistrations() {
        $this->requireAuth();
        
        $registrations = $this->tournamentModel->getUserRegistrations(Auth::id());
        
        $data = [
            'title' => 'My Tournament Registrations',
            'current_route' => 'tournaments',
            'registrations' => $registrations
        ];
        
        $this->view('tournaments/my_registrations', $data);
    }
}
?>