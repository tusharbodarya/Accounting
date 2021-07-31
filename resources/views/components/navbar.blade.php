<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item active"> <a class="nav-link" href="{{ url('/welcome') }}"><i class="icon-speedometer"></i>
                            Home</a> </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-Sales" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-customize mr-2"></i>Sales <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-Sales">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-Salesinside"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sales <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-Salesinside">
                                    <a href="{{ url('/saleinvoice/create') }}" class="dropdown-item">New Invoice</a>
                                    <a href="{{ url('/saleinvoice') }}" class="dropdown-item">Manage Invoices</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-SalesChallans"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sales Challans <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-SalesChallans">
                                    <a href="{{ url('/salechallan') }}" class="dropdown-item">New sales Challan</a>
                                    <a href="{{ url('/show-salechallan') }}" class="dropdown-item">Manage Sales Challans</a>
                                </div>
                            </div>
                            <a href="tbl-customercredit.php" class="dropdown-item">Credit Notes</a>
                        </div>
                    </li>
                    <!-- 2 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-Purchase" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-customize mr-2"></i>Purchase <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-Purchase">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-PurchaseOrder"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Purchase Order <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-PurchaseOrder">
                                    <a href="{{ url('/purchaseinvoice/create') }}" class="dropdown-item">New Purchase Order</a>
                                    <a href="{{ url('/purchaseinvoice') }}" class="dropdown-item">Manage Purchase Orders</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-PurchaseChallan"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Purchase Challans <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-PurchaseChallan">
                                    <a href="{{ url('/purchasechallan') }}" class="dropdown-item">New Purchase Challan</a>
                                    <a href="{{ url('/show-purchasechallan') }}" class="dropdown-item">Manage Purchase Challans</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-StockReturn"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Stock Return <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-StockReturn">
                                    <a href="{{ url('/salesreturn') }}" class="dropdown-item">Sales Records</a>
                                    <a href="{{ url('/purchasereturn') }}" class="dropdown-item">Purchase Records</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-Suppliers"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Job Work <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-Suppliers">
                                    <a href="{{ url('/jobworkchallan') }}" class="dropdown-item">New Job Work Challan</a>
                                    <a href="{{ url('/show-jobworkchallan') }}" class="dropdown-item">Manage Job Work Challan</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- 2 -->
                    <!-- 4 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-Products" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-customize mr-2"></i>Products <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-Products">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ItemsManager"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Items Manager <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-ItemsManager">
                                    <a href="{{ url('/product/create') }}" class="dropdown-item">New Product</a>
                                    <a href="{{ url('/product') }}" class="dropdown-item">Manage Products</a>
                                </div>
                            </div>
                            <a href="{{ url('/add-productCategory') }}" class="dropdown-item">New Product Categories</a>
                            <a href="{{ url('/tbl-productCatagories') }}" class="dropdown-item">Manage Categories</a>
                        </div>
                    </li>
                    <!-- 4 -->
                    <!-- 5 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-Accounts" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-customize mr-2"></i>Accounts <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-Accounts">
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-AccountsBook"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Accounts Book <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-AccountsBook">
                                    <a href="{{ url('/tbl-accounts') }}" class="dropdown-item">Accounts</a>
                                    <a href="{{ url('/tbl-accountsgroup') }}" class="dropdown-item">Account Group</a>
                                    <a href="{{ url('/accountstatement') }}" class="dropdown-item">Account Statements</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-Transactions"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Transactions <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-Transactions">
                                    <a href="{{ url('/transaction') }}" class="dropdown-item">View Transactions</a>
                                    <a href="{{ url('/add-banktransaction') }}" class="dropdown-item">BANK</a>
                                    <a href="ecommerce-orders.html" class="dropdown-item">CASH</a>
                                    <a href="ecommerce-customers.html" class="dropdown-item">Income</a>
                                    <a href="ecommerce-customers.html" class="dropdown-item">Expense</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-BalanceSheet"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Balance Sheet <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-BalanceSheet">
                                    <a href="{{ url('/trading') }}" class="dropdown-item">View Trading</a>
                                    <a href="{{ url('/profit_loss') }}" class="dropdown-item">View Profit & Loss</a>
                                    <a href="{{ url('/balancesheet') }}" class="dropdown-item">View Balance sheet</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- 5 -->
                    <!-- 6 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-DataReports" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-customize mr-2"></i>Data &amp; Reports <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-DataReports">

                            <a href="#" class="dropdown-item">Business Registers</a>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-Statements"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Statements <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-Statements">
                                    <a href="#" class="dropdown-item">Account Statements</a>
                                    <a href="#" class="dropdown-item">Customer Account Statements</a>
                                    <a href="#" class="dropdown-item">Supplier Account Statements</a>
                                    <a href="#" class="dropdown-item">TAX Statements</a>
                                    <a href="#" class="dropdown-item">Product Sales Reports</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#"
                                    id="topnav-GraphicalReports" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Graphical Reports <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-GraphicalReports">
                                    <a href="#" class="dropdown-item">Product Categories</a>
                                    <a href="#.html" class="dropdown-item">Trending Products</a>
                                    <a href="#" class="dropdown-item">Profit</a>
                                    <a href="#" class="dropdown-item">Top_Customers</a>
                                    <a href="#" class="dropdown-item">Income vs Expenses</a>
                                    <a href="#" class="dropdown-item">Income</a>
                                    <a href="#" class="dropdown-item">Expenses</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-SummaryReport"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Summary &amp; Report <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-SummaryReport">
                                    <a href="#" class="dropdown-item">Statistics</a>
                                    <a href="#" class="dropdown-item">Profit</a>
                                    <a href="#" class="dropdown-item">Calculate Income</a>
                                    <a href="#" class="dropdown-item">Calculate Expenses</a>
                                    <a href="#" class="dropdown-item">Sales</a>
                                    <a href="#" class="dropdown-item">Products</a>
                                    <a href="#" class="dropdown-item">Employee Commission</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- 6 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-Miscellaneous" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-file mr-2"></i>Miscellaneous <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-Miscellaneous">
                            <a href="tbl-notes.php" class="dropdown-item">Notes</a>
                            <a href="calendar.php" class="dropdown-item">Calendar</a>
                        </div>
                    </li>
                    <!-- 7 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-HRM" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-customize mr-2"></i>HRM <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-HRM">

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-Employees"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Employees <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-Employees">
                                    <a href="#" class="dropdown-item">Employees</a>
                                    <a href="#" class="dropdown-item">Permissions</a>
                                    <a href="#" class="dropdown-item">Salaries</a>
                                    <a href="#" class="dropdown-item">Attendance</a>
                                    <a href="#" class="dropdown-item">Holidays</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-Clientsinside"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Clients <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-Clientsinside">
                                    <a href="add-clients.php" class="dropdown-item">New Client</a>
                                    <a href="tbl-clients.php" class="dropdown-item">Manage Clients</a>
                                </div>
                            </div>
                            <a href="tbl-clientgroup.php" class="dropdown-item">Client Groups</a>
                            <a href="#" class="dropdown-item">Departments</a>
                            <a href="#" class="dropdown-item">Payroll</a>

                        </div>
                    </li>
                    <!-- 7 -->
                </ul>
            </div>
        </nav>
    </div>
</div>
