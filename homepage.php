<?php
$PageSecurity=0;
include('includes/session.inc');
include('includes/SQL_CommonFunctions.inc');

echo '<link rel="shortcut icon" href="'.$RootPath.'/comerp.ico" />';
echo '<link rel="icon" href="'.$RootPath.'/comerp.ico" />';

// Bootstrap 5 and modern CSS (LOCAL)
echo '<link rel="stylesheet" href="'.$RootPath.'/css/bootstrap5.min.css" type="text/css"/>
      <link rel="stylesheet" href="'.$RootPath.'/css/fontawesome-fix.css" type="text/css"/>
      <link rel="stylesheet" href="'.$RootPath.'/css/homepage-modern.css" type="text/css"/>';

// Chart.js, Bootstrap JS, and modern scripts
echo '<script src="'.$RootPath.'/javascripts/bootstrap5.bundle.min.js"></script>
      <script src="'.$RootPath.'/javascripts/chart.min.js"></script>
      <script src="'.$RootPath.'/javascripts/jquery-3.6.0.min.js"></script>
      <script type="text/javascript" src="'.$RootPath.'/javascripts/MiscFunctions.min.js"></script>
      <script type="text/javascript" src="'.$RootPath.'/javascripts/modern-dashboard.js"></script>';

// Modern Dashboard Structure
echo '
<div class="dashboard-wrapper">
    <!-- Hero Section with Gradient -->
    <div class="hero-section">
        <div class="container-fluid">
            <div class="row align-items-center py-2">
                <div class="col-md-8">
                    <h2 class="text-white fw-bold">Smart ERP Dashboard</h2>
                    <p class="text-white-50 fs-6 mt-2">Welcome back! Here\'s your business at a glance.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="text-white-50 small">
                        <i class="fas fa-calendar"></i> ' . date('l, j F Y') . '
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid py-2">
        <!-- KPI Cards Row -->
        <div class="row g-2 mb-3">
            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-blue">
                    <div class="kpi-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">Purchase Orders</h6>
                        <h2 class="kpi-value">'.CountPO(1).'</h2>
                        <p class="kpi-text">Pending Approval</p>
                        <a href="ApprovePurchase.php" target="mainContentIFrame" class="btn btn-sm btn-light mt-2">
                            Review <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-purple">
                    <div class="kpi-icon">
                        <i class="fas fa-warehouse"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">Store Requests</h6>
                        <h2 class="kpi-value">'.CountPO(2).'</h2>
                        <p class="kpi-text">Waiting Approval</p>
                        <a href="ApproveStcokissues.php" target="mainContentIFrame" class="btn btn-sm btn-light mt-2">
                            Review <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-green">
                    <div class="kpi-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">Vouchers (Finance)</h6>
                        <h2 class="kpi-value">'.CountPO(3).'</h2>
                        <p class="kpi-text">Needs Authorization</p>
                        <a href="PDFFAMpaymentvoucher.php" target="mainContentIFrame" class="btn btn-sm btn-light mt-2">
                            Review <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-orange">
                    <div class="kpi-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">CEO Vouchers</h6>
                        <h2 class="kpi-value">'.CountPO(4).'</h2>
                        <p class="kpi-text">CEO Approval</p>
                        <a href="PDFCEOpaymentvoucher.php" target="mainContentIFrame" class="btn btn-sm btn-light mt-2">
                            Review <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary KPIs -->
        <div class="row g-2 mb-3">
            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-teal">
                    <div class="kpi-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">Price Lists</h6>
                        <h2 class="kpi-value">'.CountPO(6).'</h2>
                        <p class="kpi-text">Awaiting Approval</p>
                        <a href="ApprovePriceList.php" target="mainContentIFrame" class="btn btn-sm btn-light mt-2">
                            Review <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-pink">
                    <div class="kpi-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">Lab Tests</h6>
                        <h2 class="kpi-value">'.CountPO(7).'</h2>
                        <p class="kpi-text">Pending Review</p>
                        <a href="LaboratoryDataEntry.php" target="mainContentIFrame" class="btn btn-sm btn-light mt-2">
                            Review <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-red">
                    <div class="kpi-icon">
                        <i class="fas fa-dolly"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">Stock Replenish</h6>
                        <h2 class="kpi-value">'.CountPO(14).'</h2>
                        <p class="kpi-text">Below Reorder Level</p>
                        <a href="ApproveStcokissues.php" target="mainContentIFrame" class="btn btn-sm btn-light mt-2">
                            Action <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6">
                <div class="kpi-card gradient-indigo">
                    <div class="kpi-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="kpi-content">
                        <h6 class="kpi-label">Dashboard</h6>
                        <h2 class="kpi-value">Live</h2>
                        <p class="kpi-text">System Status</p>
                        <a href="javascript:void(0)" class="btn btn-sm btn-light mt-2">
                            Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics Row -->
        <div class="row g-2 mb-3">
            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>To Do List</h5>
                    </div>
                    <div class="card-body">
                        <div class="todo-list">
                            <div class="todo-item">
                                <div class="todo-icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="todo-content">
                                    <h6>Update Commissions</h6>
                                    <a href="#" target="mainContentIFrame" class="small text-primary">Manage Commissions</a>
                                </div>
                            </div>
                            <div class="todo-item">
                                <div class="todo-icon">
                                    <i class="fas fa-box text-warning"></i>
                                </div>
                                <div class="todo-content">
                                    <h6>Un-Delivered Purchase Orders</h6>
                                    <a href="PurchaseOrderList.php" target="mainContentIFrame" class="small text-primary">'.CountPO(9).' items</a>
                                </div>
                            </div>
                            <div class="todo-item">
                                <div class="todo-icon">
                                    <i class="fas fa-file-invoice text-info"></i>
                                </div>
                                <div class="todo-content">
                                    <h6>Un-invoiced Purchase Orders</h6>
                                    <a href="GoodsReceivedNote.php" target="mainContentIFrame" class="small text-primary">'.CountPO(11).' items</a>
                                </div>
                            </div>
                            <div class="todo-item">
                                <div class="todo-icon">
                                    <i class="fas fa-money-check text-danger"></i>
                                </div>
                                <div class="todo-content">
                                    <h6>Un-posted Cheques</h6>
                                    <a href="WriteCheque.php" target="mainContentIFrame" class="small text-primary">'.CountPO(5).' pending</a>
                                </div>
                            </div>
                            <div class="todo-item">
                                <div class="todo-icon">
                                    <i class="fas fa-truck text-success"></i>
                                </div>
                                <div class="todo-content">
                                    <h6>Un-Collected Sales Orders</h6>
                                    <a href="SalesDelivery.php" target="mainContentIFrame" class="small text-primary">'.CountPO(10).' ready</a>
                                </div>
                            </div>
                            <div class="todo-item">
                                <div class="todo-icon">
                                    <i class="fas fa-file text-primary"></i>
                                </div>
                                <div class="todo-content">
                                    <h6>Un-posted Sales Orders</h6>
                                    <a href="SalesInvoice.php" target="mainContentIFrame" class="small text-primary">'.CountPO(12).' items</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0"><i class="fas fa-university me-2"></i>Bank Accounts</h5>
                    </div>
                    <div class="card-body">';

$BankSecurity = $_SESSION['PageSecurityArray'][basename('BankReconciliation.php')]; 
if ((in_array($BankSecurity, $_SESSION['AllowedPageSecurityTokens']) )) {
   echo GetMyBankBalancesModern();
} else {
   echo '<p class="text-muted">You do not have access to bank information</p>';
}

echo '
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks and Activities Row -->
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>My Tasks</h5>
                        <a href="crmclientsTasks.php?new=yes" target="mainContentIFrame" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>New Task
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="task-list">
                            '.GetMytacksModern().'
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>My Activities</h5>
                        <a href="crmclientsActivity.php?new=yes" target="mainContentIFrame" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>New Activity
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            '.GetMyActivitiesModern().'
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="'.$RootPath.'/javascripts/treeview/tree.js"></script>';

function getbanklastbalance($accountcode){
     global $db;
    
    $ResultIndex = DB_query("Select sum(`amount`) from `BankTransactions`  where (`bankcode`='".$accountcode."' ) ",$db);
    $cashbookbalance=DB_fetch_row($ResultIndex);
    $show=number_format($cashbookbalance[0],2);
    if (in_array($_SESSION['PageSecurityArray']['WWW_Users.php'], $_SESSION['AllowedPageSecurityTokens'])) {
        $return =$show;
    }else{
         $return ='Information not avilable';
    }
    return $return;
}

function Getstockbalance($itemcode){
    global $db;
   
    $SQLSTMENT="select  
                    stockmaster.`descrip` ,
                    unit.descrip as uom,
                    (sum(`stockledger`.`PartPerUnit` * stockledger.fulqty) + sum(stockledger.loosqty))
                from `stockmaster`  
                join stockledger on stockmaster.itemcode=stockledger.itemcode 
                left join `unit` on `stockmaster`.`units`=`unit`.code
                where stockmaster.itemcode='".$itemcode."'
		GROUP BY `stockledger`.`PartPerUnit`,
                `stockmaster`.reorderlevel,
                stockmaster.`descrip`,
                unit.descrip";
    
     $results =  DB_query($SQLSTMENT,$db);
     $row =DB_fetch_row($results);
     
return number_format($row[2],0) .' '.$row[1]	;
}

function GetContact($pkey){
    global $db;
    
     $result=DB_query("SELECT `company`
      ,`postcode` ,`city` ,`country`,`Physical_Address`,`PIN_VAT` ,`phone` ,`email` ,`salesman`
      ,`Contact_Name` ,`Contact_Designation`,`Contact_Telephone`,`Contact_email`
      ,`Alt_Contact_Name` ,`Alt_Contact_Designation`,`Alt_Contact_Telephone`,`Alt_Contact_email`
      ,`createdby`  FROM `NewContacts` where pkey='".$pkey."'",$db);
    $myrow = DB_fetch_row($result);
    return $myrow;
}

function CountPO($Index=0){
    Global $db;
    $sqlarray=array();
    
    $sqlarray[1] ="select count(*) from `PurchaseHeader` where `PurchaseHeader`.`documenttype`='18' and `PurchaseHeader`.`released` IS NULL ";
    $sqlarray[2] ="select count(*) from `SalesHeader` where `SalesHeader`.`documenttype`='40' and `SalesHeader`.`status`=1 ";
    $sqlarray[3] ="select count(*) FROM `paymentvoucherheader` where `paymentvoucherheader`.`status`=0 ";
    $sqlarray[4] ="select count(*) FROM `paymentvoucherheader` where `paymentvoucherheader`.`status`=1 ";
    $sqlarray[5] ="select count(*) FROM `paymentvoucherheader` where `paymentvoucherheader`.`status`=2 ";
    $sqlarray[6] ="SELECT count(*) FROM `PriceList` where approved=0 and customerCode='' or  customerCode is null";
    $sqlarray[7] ="SELECT count(*) FROM `ProductionMaster` where `testreport` is null and `itemcode` is not null";
    $sqlarray[8] ="select count(*) from `PurchaseHeader` where printed is null or printed=0";
    $sqlarray[9] ="select count(*) from `PurchaseHeader` where `documenttype`='18' and `released`=1";
    $sqlarray[10]="select count(*) from SalesHeader where `documenttype`='1' and `released`=1";
    $sqlarray[11]="select count(*) from `PurchaseHeader` where `documenttype`='18' and `released`=1";
    $sqlarray[12]="select count(*) from SalesHeader where `documenttype`='1' and `released`=1";
    $sqlarray[13]="select count(*) from SalesHeader where `documenttype`='32' and `released`=1";
    $sqlarray[14]="select count(*) FROM `stockmaster` where stockmaster.itemcode in
        (select  stockmaster.itemcode  from `stockmaster` 
        join stockledger on stockmaster.itemcode=stockledger.itemcode
		GROUP BY `stockledger`.`PartPerUnit`,`stockmaster`.reorderlevel,stockmaster.itemcode
		having (`stockmaster`.reorderlevel) >  (sum(`stockledger`.`PartPerUnit` * stockledger.fulqty) + sum(stockledger.loosqty))
		)  ";
    
        $results =  DB_query($sqlarray[$Index], $db);
        if(DB_num_rows($results)>0){
             $myrow=DB_fetch_row($results);
            if($myrow[0]>0){
                if($Index==14){
                         
                $SQLSTMENT="select  
                    stockmaster.`descrip` ,
                    stockmaster.`eoq` ,
                    stockmaster.itemcode
                from `stockmaster` 
                join stockledger on stockmaster.itemcode=stockledger.itemcode
		GROUP BY  
                stockmaster.itemcode,
                `stockledger`.`PartPerUnit`,
                `stockmaster`.reorderlevel,
                stockmaster.`descrip`,
                stockmaster.`eoq`
		having (`stockmaster`.reorderlevel) > (sum(`stockledger`.`PartPerUnit` * stockledger.fulqty) + sum(stockledger.loosqty)) ";
            
                $return='<div>'
                        . '<div>'
                        . '<ul class="nav nav-list">'
                        . '<li><label class="tree-toggler nav-header">Purchase Or Manufacture The Following</label>'
                        . '<ul class="nav nav-list tree">';

                 $results =  DB_query($SQLSTMENT,$db);
                 while($row= DB_fetch_array($results)){  
                     $return .='<li><label class="tree-toggler nav-header grouper">'.$row['descrip'].' :- Current Stock Balance :'.Getstockbalance($row['itemcode']).'</label></li>'; 
                  }

                 $return .='</ul></li></ul>'
                         . '</div></div>';
                        
  
                }else{
                    $return = (($myrow[0]>0)?_('There is some work here'):'');
                }
            }else{
                $return="No items, Good work !";
            }
        }else{
           $return="No items";
        }
        
  
  return $return;
}

function GetMyBankBalancesModern(){
    global $db;
    
    $sql="SELECT 
           `accountcode`
          ,`bankName`
          ,`currency`
          ,`lastreconcileddate`
          ,`AccountNo`
          ,`BranchCode`
          ,`BranchName`
          ,`lastreconbalance`
          ,`lastChequeno`
          ,`PostingGroup`
          ,`Fluctuation`
          ,`Makeinactive`
          ,lastreconbalance
          ,`AcctName`
          ,`bankCode`
          ,`swiftcode`
      FROM `BankAccounts`
      where (`Makeinactive`=0 or `Makeinactive` is null)";
    
    $lineecho = '<div class="bank-accounts-list">';
    $ResultIndex=DB_query($sql,$db);
    
    $count = 0;
    while( $rowbanks = DB_fetch_array($ResultIndex)){
        $count++;
        $cbBalance = getbanklastbalance($rowbanks['accountcode']);
        $lineecho .= '
        <div class="bank-item">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h6 class="mb-1 text-dark fw-bold">'.$rowbanks['bankName'].'</h6>
                    <p class="small text-muted mb-1">
                        <i class="fas fa-credit-card"></i> '.$rowbanks['AccountNo'].'
                    </p>
                </div>
                <span class="badge badge-modern">'.$rowbanks['currency'].'</span>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <p class="small text-muted mb-1">Last Reconciled</p>
                    <p class="fs-7 fw-bold">'.ConvertSQLDate($rowbanks['lastreconcileddate']).'</p>
                </div>
                <div class="col-6 text-end">
                    <p class="small text-muted mb-1">Statement Balance</p>
                    <p class="fs-7 fw-bold text-success">'.number_format($rowbanks['lastreconbalance'],2).'</p>
                </div>
                <div class="col-6">
                    <p class="small text-muted mb-1">CB Balance</p>
                    <p class="fs-7 fw-bold">'.$cbBalance.'</p>
                </div>
                <div class="col-6 text-end">
                    <p class="small text-muted mb-1">Last Cheque</p>
                    <p class="fs-7 fw-bold">'.$rowbanks['lastChequeno'].'</p>
                </div>
            </div>
            ' . ($count < DB_num_rows($ResultIndex) ? '<hr class="my-2">' : '') . '
        </div>';
    }
   
    $lineecho .= '</div>';
    return (DB_num_rows($ResultIndex) > 0) ? $lineecho : '<p class="text-muted">No bank accounts found</p>';
}

function GetMytacksModern(){
    global $db;
    
    $sql = "SELECT * FROM `Tasks` LIMIT 10";
    $result = DB_query($sql, $db);
    
    $lineecho = '';
    if(DB_num_rows($result) > 0){
        while($row = DB_fetch_array($result)){
            $status = isset($row['Status']) ? $row['Status'] : '0';
            $statusClass = ($status == '4') ? 'success' : 'warning';
            $statusIcon = ($status == '4') ? 'check-circle' : 'hourglass-half';
            
            $lineecho .= '
            <div class="task-item">
                <div class="task-check">
                    <i class="fas fa-'.$statusIcon.' text-'.$statusClass.'"></i>
                </div>
                <div class="task-info">
                    <p class="task-title mb-1">'.$row['Taskname'].'</p>
                    <p class="task-description small text-muted">'.$row['taskdetails'].'</p>
                </div>
            </div>';
        }
    } else {
        $lineecho = '<p class="text-muted text-center py-2"><i class="fas fa-smile-wink"></i> No tasks yet. Great job!</p>';
    }
    
    return $lineecho;
}

function GetMyActivitiesModern(){
    global $db;
    
    $sql = "SELECT * FROM `NewActivity` LIMIT 10";
    $result = DB_query($sql, $db);
    
    $lineecho = '';
    if(DB_num_rows($result) > 0){
        while($row = DB_fetch_array($result)){
            $type = strtolower(trim($row['Activityname']));
            
            // Determine icon based on activity type
            switch($type) {
                case 'call':
                    $typeIcon = 'phone';
                    break;
                case 'email':
                    $typeIcon = 'envelope';
                    break;
                case 'meeting':
                case 'sales':
                    $typeIcon = 'users';
                    break;
                case 'note':
                    $typeIcon = 'sticky-note';
                    break;
                default:
                    $typeIcon = 'star';
            }
            
            $lineecho .= '
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-'.$typeIcon.'"></i>
                </div>
                <div class="activity-info">
                    <p class="activity-title mb-1">'.$row['Activityname'].'</p>
                    <p class="activity-description small text-muted">'.$row['taskdetails'].'</p>
                    <p class="activity-date small text-muted-50">'.date('j M Y', strtotime($row['createdon'])).'</p>
                </div>
            </div>';
        }
    } else {
        $lineecho = '<p class="text-muted text-center py-2"><i class="fas fa-check-double"></i> All caught up!</p>';
    }
    
    return $lineecho;
}
 