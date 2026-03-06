<?php
/**
 * Dashboard Page - Default landing page
 * Displays KPIs and quick stats
 */

include('includes/session.inc');
include('includes/SQL_CommonFunctions.inc');
?>

<!-- Dashboard Content -->
<div class="dashboard-section">
    <!-- Welcome Header -->
    <div class="mb-4">
        <h4 class="text-primary fw-bold mb-2">Welcome back!</h4>
        <p class="text-muted">Here's what's happening in your Smart ERP system today.</p>
    </div>

    <!-- KPI Cards Row -->
    <div class="row g-3 mb-4">
        <!-- Pending Purchase Orders -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Pending POs</p>
                            <h5 class="text-primary fw-bold">
                                <?php 
                                echo CountPO(1);
                                ?>
                            </h5>
                            <small class="text-muted">Awaiting approval</small>
                        </div>
                        <i class="fas fa-shopping-cart fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outstanding Sales Orders -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Outstanding SOs</p>
                            <h5 class="text-success fw-bold">
                                <?php 
                                echo CountPO(2);
                                ?>
                            </h5>
                            <small class="text-muted">Pending shipment</small>
                        </div>
                        <i class="fas fa-truck fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Pending Payments</p>
                            <h5 class="text-warning fw-bold">
                                <?php 
                                echo CountPO(3);
                                ?>
                            </h5>
                            <small class="text-muted">Awaiting authorization</small>
                        </div>
                        <i class="fas fa-money-bill fa-2x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">Low Stock</p>
                            <h5 class="text-danger fw-bold">
                                <?php 
                                echo CountPO(14);
                                ?>
                            </h5>
                            <small class="text-muted">Below reorder level</small>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row g-3">
        <!-- Bank Accounts -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0"><i class="fas fa-university me-2"></i>Bank Accounts</h6>
                </div>
                <div class="card-body">
                    <?php
                    $bankSql = "SELECT * FROM `BankAccounts` WHERE Makeinactive=0 OR Makeinactive IS NULL LIMIT 5";
                    $bankResult = DB_query($bankSql);
                    
                    if(DB_num_rows($bankResult) > 0) {
                        while($bankRow = DB_fetch_array($bankResult)) {
                            echo '
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-0">' . htmlspecialchars($bankRow['bankName']) . '</h6>
                                    <small class="text-muted">' . htmlspecialchars($bankRow['AccountNo']) . '</small>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 text-success fw-bold">Balance: ' . htmlspecialchars($bankRow['lastreconbalance']) . '</p>
                                    <small class="text-muted">' . htmlspecialchars($bankRow['currency']) . '</small>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '<p class="text-muted text-center py-3">No bank accounts configured</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Tasks -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h6 class="mb-0"><i class="fas fa-tasks me-2"></i>Recent Tasks</h6>
                </div>
                <div class="card-body">
                    <?php
                    $taskSql = "SELECT * FROM `Tasks` LIMIT 5";
                    $taskResult = DB_query($taskSql);
                    
                    if(DB_num_rows($taskResult) > 0) {
                        while($taskRow = DB_fetch_array($taskResult)) {
                            $statusClass = ($taskRow['Status'] == '4') ? 'success' : 'warning';
                            $statusText = ($taskRow['Status'] == '4') ? 'Completed' : 'Pending';
                            
                            echo '
                            <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                                <div>
                                    <span class="badge bg-' . $statusClass . '">' . $statusText . '</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">' . htmlspecialchars($taskRow['Taskname']) . '</h6>
                                    <small class="text-muted">' . htmlspecialchars($taskRow['taskdetails']) . '</small>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '<p class="text-muted text-center py-3">No tasks assigned</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-section {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
}
</style>
