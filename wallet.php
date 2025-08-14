<?php
require_once 'includes/functions.php';

// Require login for wallet
requireLogin();

$page_title = t('wallet');
$error = '';
$success = '';

$user_id = $_SESSION['user_id'];

// Handle deposit/withdrawal requests
if ($_POST) {
    if (isset($_POST['deposit'])) {
        $amount = (float)($_POST['amount'] ?? 0);
        $method = $_POST['method'] ?? '';
        $reference = sanitizeInput($_POST['reference'] ?? '');
        
        if ($amount < MIN_DEPOSIT_AMOUNT) {
            $error = getCurrentLang() == 'tr' ? 
                'Minimum para yatırma tutarı ' . MIN_DEPOSIT_AMOUNT . ' TL' : 
                'Minimum deposit amount is ' . MIN_DEPOSIT_AMOUNT . ' TL';
        } elseif (!in_array($method, ['iban', 'papara'])) {
            $error = getCurrentLang() == 'tr' ? 'Geçersiz ödeme yöntemi' : 'Invalid payment method';
        } else {
            $database = new Database();
            $db = $database->getConnection();
            
            $query = "INSERT INTO deposits (user_id, amount, method, reference) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            
            if ($stmt->execute([$user_id, $amount, $method, $reference])) {
                $success = t('deposit_request_sent');
                logActivity($user_id, 'deposit_request', "Amount: $amount TL, Method: $method");
            } else {
                $error = getCurrentLang() == 'tr' ? 'Bir hata oluştu' : 'An error occurred';
            }
        }
    }
    
    if (isset($_POST['withdraw'])) {
        $amount = (float)($_POST['amount'] ?? 0);
        $method = $_POST['method'] ?? '';
        $iban_info = sanitizeInput($_POST['iban_info'] ?? '');
        $papara_info = sanitizeInput($_POST['papara_info'] ?? '');
        
        $balance_tl = getUserBalance($user_id, 'tl');
        
        if ($amount < MIN_WITHDRAWAL_AMOUNT) {
            $error = getCurrentLang() == 'tr' ? 
                'Minimum para çekme tutarı ' . MIN_WITHDRAWAL_AMOUNT . ' TL' : 
                'Minimum withdrawal amount is ' . MIN_WITHDRAWAL_AMOUNT . ' TL';
        } elseif ($amount > $balance_tl) {
            $error = t('insufficient_balance');
        } elseif (!in_array($method, ['iban', 'papara'])) {
            $error = getCurrentLang() == 'tr' ? 'Geçersiz ödeme yöntemi' : 'Invalid payment method';
        } elseif ($method == 'iban' && empty($iban_info)) {
            $error = getCurrentLang() == 'tr' ? 'IBAN bilgisi gerekli' : 'IBAN information required';
        } elseif ($method == 'papara' && empty($papara_info)) {
            $error = getCurrentLang() == 'tr' ? 'Papara bilgisi gerekli' : 'Papara information required';
        } else {
            $database = new Database();
            $db = $database->getConnection();
            
            $query = "INSERT INTO withdrawals (user_id, amount, method, iban_info, papara_info) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            
            if ($stmt->execute([$user_id, $amount, $method, $iban_info, $papara_info])) {
                $success = t('withdrawal_request_sent');
                logActivity($user_id, 'withdrawal_request', "Amount: $amount TL, Method: $method");
            } else {
                $error = getCurrentLang() == 'tr' ? 'Bir hata oluştu' : 'An error occurred';
            }
        }
    }
}

// Get user balances
$balance_tl = getUserBalance($user_id, 'tl');
$balance_usd = getUserBalance($user_id, 'usd');
$balance_btc = getUserBalance($user_id, 'btc');
$balance_eth = getUserBalance($user_id, 'eth');

// Get recent deposits and withdrawals
$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM deposits WHERE user_id = ? ORDER BY created_at DESC LIMIT 10";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$deposits = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM withdrawals WHERE user_id = ? ORDER BY created_at DESC LIMIT 10";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$withdrawals = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container">
    <div class="row">
        <!-- Wallet Overview -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0"><?php echo t('wallet'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-lira-sign fa-2x text-primary mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatNumber($balance_tl); ?></div>
                                <small class="text-muted">Türk Lirası</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatNumber($balance_usd); ?></div>
                                <small class="text-muted">US Dollar</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fab fa-bitcoin fa-2x text-warning mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatPrice($balance_btc); ?></div>
                                <small class="text-muted">Bitcoin</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fab fa-ethereum fa-2x text-info mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatPrice($balance_eth); ?></div>
                                <small class="text-muted">Ethereum</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Deposit/Withdraw Forms -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Deposit/Withdraw Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3" id="walletTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="deposit-tab" data-bs-toggle="pill" data-bs-target="#deposit" type="button">
                                <i class="fas fa-plus me-1"></i><?php echo t('deposit'); ?>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="withdraw-tab" data-bs-toggle="pill" data-bs-target="#withdraw" type="button">
                                <i class="fas fa-minus me-1"></i><?php echo t('withdraw'); ?>
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="walletTabsContent">
                        <!-- Deposit Form -->
                        <div class="tab-pane fade show active" id="deposit" role="tabpanel">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Yatırılacak Tutar' : 'Deposit Amount'; ?></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="amount" step="0.01" 
                                               min="<?php echo MIN_DEPOSIT_AMOUNT; ?>" required>
                                        <span class="input-group-text">TL</span>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo getCurrentLang() == 'tr' ? 'Minimum:' : 'Minimum:'; ?> 
                                        <?php echo MIN_DEPOSIT_AMOUNT; ?> TL
                                    </small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Ödeme Yöntemi' : 'Payment Method'; ?></label>
                                    <select class="form-select" name="method" required>
                                        <option value=""><?php echo getCurrentLang() == 'tr' ? 'Seçiniz' : 'Select'; ?></option>
                                        <option value="iban">IBAN (Banka Havalesi)</option>
                                        <option value="papara">Papara</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Referans/Açıklama' : 'Reference/Description'; ?></label>
                                    <input type="text" class="form-control" name="reference" 
                                           placeholder="<?php echo getCurrentLang() == 'tr' ? 'İşlem referansı veya açıklama' : 'Transaction reference or description'; ?>">
                                </div>
                                
                                <button type="submit" name="deposit" class="btn btn-success w-100">
                                    <i class="fas fa-plus me-2"></i><?php echo t('deposit'); ?>
                                </button>
                            </form>
                            
                            <!-- Deposit Instructions -->
                            <div class="mt-4 p-3 bg-info bg-opacity-10 border border-info rounded">
                                <h6 class="text-info"><?php echo getCurrentLang() == 'tr' ? 'Para Yatırma Talimatları' : 'Deposit Instructions'; ?></h6>
                                <small class="text-muted">
                                    <strong>IBAN:</strong> TR12 3456 7890 1234 5678 90<br>
                                    <strong>Hesap Adı:</strong> GlobalBorsa Ltd.<br>
                                    <strong>Papara No:</strong> 1234567890<br>
                                    <br>
                                    <?php echo getCurrentLang() == 'tr' ? 
                                        'Havale/EFT açıklama kısmına kullanıcı adınızı yazınız.' : 
                                        'Please include your username in the transfer description.'; ?>
                                </small>
                            </div>
                        </div>
                        
                        <!-- Withdraw Form -->
                        <div class="tab-pane fade" id="withdraw" role="tabpanel">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Çekilecek Tutar' : 'Withdrawal Amount'; ?></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="amount" step="0.01" 
                                               min="<?php echo MIN_WITHDRAWAL_AMOUNT; ?>" max="<?php echo $balance_tl; ?>" required>
                                        <span class="input-group-text">TL</span>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo getCurrentLang() == 'tr' ? 'Kullanılabilir:' : 'Available:'; ?> 
                                        <?php echo formatNumber($balance_tl); ?> TL
                                    </small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Ödeme Yöntemi' : 'Payment Method'; ?></label>
                                    <select class="form-select" name="method" id="withdrawMethod" required>
                                        <option value=""><?php echo getCurrentLang() == 'tr' ? 'Seçiniz' : 'Select'; ?></option>
                                        <option value="iban">IBAN (Banka Hesabı)</option>
                                        <option value="papara">Papara</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3" id="ibanInfo" style="display: none;">
                                    <label class="form-label">IBAN <?php echo getCurrentLang() == 'tr' ? 'Bilgileri' : 'Information'; ?></label>
                                    <textarea class="form-control" name="iban_info" rows="3" 
                                              placeholder="<?php echo getCurrentLang() == 'tr' ? 
                                                  'IBAN: TR12 3456 7890 1234 5678 90&#10;Hesap Sahibi: Ad Soyad&#10;Banka: Banka Adı' : 
                                                  'IBAN: TR12 3456 7890 1234 5678 90&#10;Account Holder: Full Name&#10;Bank: Bank Name'; ?>"></textarea>
                                </div>
                                
                                <div class="mb-3" id="paparaInfo" style="display: none;">
                                    <label class="form-label">Papara <?php echo getCurrentLang() == 'tr' ? 'Bilgileri' : 'Information'; ?></label>
                                    <input type="text" class="form-control" name="papara_info" 
                                           placeholder="<?php echo getCurrentLang() == 'tr' ? 'Papara hesap numarası' : 'Papara account number'; ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <div class="alert alert-warning">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            <?php echo getCurrentLang() == 'tr' ? 
                                                'Para çekme işlemi admin onayı gerektirir. İşlem süresi 1-3 iş günüdür.' : 
                                                'Withdrawal requires admin approval. Processing time is 1-3 business days.'; ?>
                                        </small>
                                    </div>
                                </div>
                                
                                <button type="submit" name="withdraw" class="btn btn-danger w-100">
                                    <i class="fas fa-minus me-2"></i><?php echo t('withdraw'); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transaction History -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><?php echo t('transaction_history'); ?></h5>
                </div>
                <div class="card-body">
                    <!-- History Tabs -->
                    <ul class="nav nav-tabs nav-fill mb-3" id="historyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#deposits" type="button">
                                <?php echo getCurrentLang() == 'tr' ? 'Para Yatırma' : 'Deposits'; ?>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="withdrawals-tab" data-bs-toggle="tab" data-bs-target="#withdrawals" type="button">
                                <?php echo getCurrentLang() == 'tr' ? 'Para Çekme' : 'Withdrawals'; ?>
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="historyTabsContent">
                        <!-- Deposits History -->
                        <div class="tab-pane fade show active" id="deposits" role="tabpanel">
                            <?php if (empty($deposits)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-plus-circle fa-2x text-muted mb-3"></i>
                                <p class="text-muted">
                                    <?php echo getCurrentLang() == 'tr' ? 'Henüz para yatırma işlemi yok' : 'No deposit history yet'; ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tarih' : 'Date'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tutar' : 'Amount'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Yöntem' : 'Method'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Durum' : 'Status'; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($deposits as $deposit): ?>
                                        <tr>
                                            <td><?php echo date('d.m.Y H:i', strtotime($deposit['created_at'])); ?></td>
                                            <td><?php echo formatNumber($deposit['amount']); ?> TL</td>
                                            <td><?php echo strtoupper($deposit['method']); ?></td>
                                            <td>
                                                <?php
                                                $status_class = $deposit['status'] == 'approved' ? 'success' : 
                                                              ($deposit['status'] == 'rejected' ? 'danger' : 'warning');
                                                ?>
                                                <span class="badge bg-<?php echo $status_class; ?>">
                                                    <?php echo t($deposit['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Withdrawals History -->
                        <div class="tab-pane fade" id="withdrawals" role="tabpanel">
                            <?php if (empty($withdrawals)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-minus-circle fa-2x text-muted mb-3"></i>
                                <p class="text-muted">
                                    <?php echo getCurrentLang() == 'tr' ? 'Henüz para çekme işlemi yok' : 'No withdrawal history yet'; ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tarih' : 'Date'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tutar' : 'Amount'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Yöntem' : 'Method'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Durum' : 'Status'; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($withdrawals as $withdrawal): ?>
                                        <tr>
                                            <td><?php echo date('d.m.Y H:i', strtotime($withdrawal['created_at'])); ?></td>
                                            <td><?php echo formatNumber($withdrawal['amount']); ?> TL</td>
                                            <td><?php echo strtoupper($withdrawal['method']); ?></td>
                                            <td>
                                                <?php
                                                $status_class = $withdrawal['status'] == 'approved' ? 'success' : 
                                                              ($withdrawal['status'] == 'rejected' ? 'danger' : 'warning');
                                                ?>
                                                <span class="badge bg-<?php echo $status_class; ?>">
                                                    <?php echo t($withdrawal['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show/hide payment method fields
document.getElementById('withdrawMethod').addEventListener('change', function() {
    const method = this.value;
    const ibanInfo = document.getElementById('ibanInfo');
    const paparaInfo = document.getElementById('paparaInfo');
    
    if (method === 'iban') {
        ibanInfo.style.display = 'block';
        paparaInfo.style.display = 'none';
        ibanInfo.querySelector('textarea').required = true;
        paparaInfo.querySelector('input').required = false;
    } else if (method === 'papara') {
        ibanInfo.style.display = 'none';
        paparaInfo.style.display = 'block';
        ibanInfo.querySelector('textarea').required = false;
        paparaInfo.querySelector('input').required = true;
    } else {
        ibanInfo.style.display = 'none';
        paparaInfo.style.display = 'none';
        ibanInfo.querySelector('textarea').required = false;
        paparaInfo.querySelector('input').required = false;
    }
});
</script>

<?php include 'includes/footer.php'; ?>
