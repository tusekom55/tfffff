<?php
require_once 'includes/functions.php';

// Require login for portfolio
requireLogin();

$page_title = t('portfolio') ?: 'Portfolio';
$error = '';
$success = '';

$user_id = $_SESSION['user_id'];

// Handle sell from portfolio
if ($_POST && isset($_POST['sell_from_portfolio'])) {
    $symbol = $_POST['symbol'] ?? '';
    $sell_quantity = (float)($_POST['sell_quantity'] ?? 0);
    
    $holding = getPortfolioHolding($user_id, $symbol);
    $market = getSingleMarket($symbol);
    
    if (!$holding) {
        $error = 'Bu varlığa sahip değilsiniz.';
    } elseif (!$market) {
        $error = 'Piyasa verisi bulunamadı.';
    } elseif ($sell_quantity <= 0 || $sell_quantity > $holding['quantity']) {
        $error = 'Geçersiz satış miktarı.';
    } else {
        // Calculate USD amount based on quantity and current price
        $usd_amount = $sell_quantity * $market['price'];
        
        // Execute the sell trade
        if (executeSimpleTrade($user_id, $symbol, 'sell', $usd_amount, $market['price'])) {
            $success = formatTurkishNumber($sell_quantity, 6) . ' ' . $symbol . ' başarıyla satıldı!';
        } else {
            $error = 'Satış işlemi başarısız oldu.';
        }
    }
}

// Get user portfolio
$portfolio = getUserPortfolio($user_id);
$portfolio_stats = getPortfolioValue($user_id);

// Get balances
$trading_currency = getTradingCurrency();
$currency_field = getCurrencyField($trading_currency);
$currency_symbol = getCurrencySymbol($trading_currency);
$balance = getUserBalance($user_id, $currency_field);

include 'includes/header.php';
?>

<div class="container">
    <!-- Portfolio Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="h4 mb-0">💼 Portföyüm</h2>
                            <p class="text-muted mb-0">Sahip olduğunuz varlıklar ve performansları</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="portfolio-stats">
                                <div class="stat-item">
                                    <small class="text-muted">Toplam Değer</small>
                                    <div class="h5 mb-0">
                                        <?php 
                                        if ($trading_currency == 1) {
                                            echo formatTurkishNumber(convertUSDToTL($portfolio_stats['current_value']), 2) . ' TL';
                                        } else {
                                            echo formatTurkishNumber($portfolio_stats['current_value'], 2) . ' USD';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="stat-item mt-2">
                                    <small class="text-muted">Kar/Zarar</small>
                                    <div class="h6 mb-0 <?php echo $portfolio_stats['profit_loss'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                        <?php 
                                        $profit_loss_display = $trading_currency == 1 ? convertUSDToTL($portfolio_stats['profit_loss']) : $portfolio_stats['profit_loss'];
                                        echo ($portfolio_stats['profit_loss'] >= 0 ? '+' : '') . formatTurkishNumber($profit_loss_display, 2) . ' ' . $currency_symbol;
                                        ?>
                                        <span class="ms-1">(<?php echo ($portfolio_stats['profit_loss_percentage'] >= 0 ? '+' : '') . formatTurkishNumber($portfolio_stats['profit_loss_percentage'], 2); ?>%)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Portfolio Holdings -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">📊 Varlıklarım</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($portfolio)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Henüz portföyünüzde varlık yok</h5>
                        <p class="text-muted">
                            Yatırım yapmak için <a href="markets.php" class="text-decoration-none">piyasalar</a> sayfasını ziyaret edin.
                        </p>
                        <a href="markets.php" class="btn btn-primary">
                            <i class="fas fa-chart-line me-2"></i>Piyasalara Git
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-4">Varlık</th>
                                    <th class="border-0 text-end">Miktar</th>
                                    <th class="border-0 text-end">Ort. Fiyat</th>
                                    <th class="border-0 text-end">Güncel Fiyat</th>
                                    <th class="border-0 text-end">Toplam Değer</th>
                                    <th class="border-0 text-end">Kar/Zarar</th>
                                    <th class="border-0 text-center pe-4">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($portfolio as $holding): ?>
                                <?php 
                                $current_value = $holding['quantity'] * $holding['current_price'];
                                $profit_loss = $current_value - $holding['total_invested'];
                                $profit_loss_percent = $holding['total_invested'] > 0 ? ($profit_loss / $holding['total_invested']) * 100 : 0;
                                ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <?php if ($holding['logo_url']): ?>
                                            <img src="<?php echo $holding['logo_url']; ?>" 
                                                 alt="<?php echo $holding['name']; ?>" 
                                                 class="me-3 rounded-circle" 
                                                 width="32" height="32"
                                                 onerror="this.outerHTML='<div class=&quot;bg-primary rounded-circle d-flex align-items-center justify-content-center me-3&quot; style=&quot;width: 32px; height: 32px;&quot;><i class=&quot;fas fa-coins text-white&quot;></i></div>';">
                                            <?php else: ?>
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 32px; height: 32px;">
                                                <i class="fas fa-coins text-white"></i>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="fw-bold"><?php echo $holding['symbol']; ?></div>
                                                <small class="text-muted"><?php echo $holding['name']; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end py-3">
                                        <div class="fw-bold"><?php echo formatTurkishNumber($holding['quantity'], 6); ?></div>
                                        <small class="text-muted">adet</small>
                                    </td>
                                    <td class="text-end py-3">
                                        <div><?php echo formatPrice($holding['avg_price']); ?></div>
                                        <small class="text-muted">USD</small>
                                    </td>
                                    <td class="text-end py-3">
                                        <div><?php echo formatPrice($holding['current_price']); ?></div>
                                        <small class="text-muted">USD</small>
                                    </td>
                                    <td class="text-end py-3">
                                        <div class="fw-bold">
                                            <?php 
                                            if ($trading_currency == 1) {
                                                echo formatTurkishNumber(convertUSDToTL($current_value), 2) . ' TL';
                                            } else {
                                                echo formatTurkishNumber($current_value, 2) . ' USD';
                                            }
                                            ?>
                                        </div>
                                        <small class="text-muted">
                                            <?php 
                                            $invested_display = $trading_currency == 1 ? convertUSDToTL($holding['total_invested']) : $holding['total_invested'];
                                            echo 'Yatırım: ' . formatTurkishNumber($invested_display, 2) . ' ' . $currency_symbol;
                                            ?>
                                        </small>
                                    </td>
                                    <td class="text-end py-3">
                                        <div class="fw-bold <?php echo $profit_loss >= 0 ? 'text-success' : 'text-danger'; ?>">
                                            <?php 
                                            $profit_loss_display = $trading_currency == 1 ? convertUSDToTL($profit_loss) : $profit_loss;
                                            echo ($profit_loss >= 0 ? '+' : '') . formatTurkishNumber($profit_loss_display, 2) . ' ' . $currency_symbol;
                                            ?>
                                        </div>
                                        <small class="<?php echo $profit_loss_percent >= 0 ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo ($profit_loss_percent >= 0 ? '+' : '') . formatTurkishNumber($profit_loss_percent, 2); ?>%
                                        </small>
                                    </td>
                                    <td class="text-center py-3 pe-4">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="showSellModal('<?php echo $holding['symbol']; ?>', '<?php echo $holding['name']; ?>', <?php echo $holding['quantity']; ?>, <?php echo $holding['current_price']; ?>)">
                                                <i class="fas fa-minus me-1"></i>Sat
                                            </button>
                                            <a href="markets.php?search=<?php echo urlencode($holding['symbol']); ?>" 
                                               class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-chart-line me-1"></i>Grafik
                                            </a>
                                        </div>
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

    <!-- Portfolio Performance Chart -->
    <?php if (!empty($portfolio)): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">📈 Portföy Dağılımı</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($portfolio as $holding): ?>
                        <?php 
                        $current_value = $holding['quantity'] * $holding['current_price'];
                        $percentage = $portfolio_stats['current_value'] > 0 ? ($current_value / $portfolio_stats['current_value']) * 100 : 0;
                        ?>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <?php if ($holding['logo_url']): ?>
                                    <img src="<?php echo $holding['logo_url']; ?>" 
                                         alt="<?php echo $holding['name']; ?>" 
                                         class="rounded-circle" 
                                         width="24" height="24">
                                    <?php else: ?>
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 24px; height: 24px;">
                                        <i class="fas fa-coins text-white" style="font-size: 10px;"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold"><?php echo $holding['symbol']; ?></span>
                                        <span class="text-muted"><?php echo formatTurkishNumber($percentage, 1); ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: <?php echo $percentage; ?>%" 
                                             aria-valuenow="<?php echo $percentage; ?>" 
                                             aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Sell Modal -->
<div class="modal fade" id="sellModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Varlık Sat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="sell_from_portfolio" value="1">
                <input type="hidden" name="symbol" id="sellSymbol">
                
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h6 id="sellAssetName">Apple Inc.</h6>
                        <p class="text-muted mb-0">Güncel Fiyat: $<span id="sellCurrentPrice">175.50</span></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Satış Miktarı</label>
                        <input type="number" class="form-control" name="sell_quantity" id="sellQuantity" 
                               step="0.000001" min="0" max="" required 
                               oninput="calculateSellTotal()">
                        <small class="text-muted">
                            Mevcut: <span id="availableQuantity">0.000000</span> adet
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setSellPercentage(25)">%25</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setSellPercentage(50)">%50</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setSellPercentage(75)">%75</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setSellPercentage(100)">Tümü</button>
                        </div>
                    </div>
                    
                    <div class="card bg-light">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Satış Tutarı:</span>
                                <span class="fw-bold" id="sellTotalUSD">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="display: none !important;">
                                <span class="text-muted">İşlem Ücreti (0.1%):</span>
                                <span id="sellFee">$0.00</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Alacağınız Tutar:</span>
                                <span class="fw-bold text-success" id="sellNetAmount">
                                    <?php echo $currency_symbol; ?> 0.00
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-hand-holding-usd me-2"></i>Sat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const TRADING_CURRENCY = <?php echo $trading_currency; ?>;
const CURRENCY_SYMBOL = '<?php echo $currency_symbol; ?>';
const USD_TRY_RATE = <?php echo getUSDTRYRate(); ?>;

let currentSellPrice = 0;
let maxQuantity = 0;

function showSellModal(symbol, name, quantity, price) {
    document.getElementById('sellSymbol').value = symbol;
    document.getElementById('sellAssetName').textContent = name;
    document.getElementById('sellCurrentPrice').textContent = formatTurkishNumber(price, 4);
    document.getElementById('availableQuantity').textContent = formatTurkishNumber(quantity, 6);
    document.getElementById('sellQuantity').max = quantity;
    
    currentSellPrice = price;
    maxQuantity = quantity;
    
    // Reset form
    document.getElementById('sellQuantity').value = '';
    calculateSellTotal();
    
    const modal = new bootstrap.Modal(document.getElementById('sellModal'));
    modal.show();
}

function setSellPercentage(percentage) {
    if (percentage === 100) {
        // "Tümü" butonunda tam değeri kullan (precision safe)
        document.getElementById('sellQuantity').value = maxQuantity.toString();
    } else {
        // Diğer yüzdelerde normal rounded değer
        const quantity = maxQuantity * (percentage / 100);
        document.getElementById('sellQuantity').value = quantity.toFixed(6);
    }
    calculateSellTotal();
}

function calculateSellTotal() {
    const quantity = parseFloat(document.getElementById('sellQuantity').value) || 0;
    
    if (quantity <= 0) {
        document.getElementById('sellTotalUSD').textContent = '$0.00';
        document.getElementById('sellFee').textContent = '$0.00';
        document.getElementById('sellNetAmount').textContent = CURRENCY_SYMBOL + ' 0.00';
        return;
    }
    
    const totalUSD = quantity * currentSellPrice;
    const feeUSD = 0; // No fee
    const netUSD = totalUSD - feeUSD;
    
    document.getElementById('sellTotalUSD').textContent = '$' + formatTurkishNumber(totalUSD, 2);
    document.getElementById('sellFee').textContent = '$' + formatTurkishNumber(feeUSD, 2);
    
    if (TRADING_CURRENCY === 1) { // TL mode
        const netTL = netUSD * USD_TRY_RATE;
        document.getElementById('sellNetAmount').textContent = formatTurkishNumber(netTL, 2) + ' TL';
    } else { // USD mode
        document.getElementById('sellNetAmount').textContent = '$' + formatTurkishNumber(netUSD, 2);
    }
}

function formatTurkishNumber(number, decimals = 2) {
    return number.toLocaleString('tr-TR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
}
</script>

<?php include 'includes/footer.php'; ?>
