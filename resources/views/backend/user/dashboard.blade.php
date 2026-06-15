@extends('backend.layouts.master')

@section('pageTitle') Dashboard @endsection

@section('extraStyle')
    <style>
        .notification li {
            font-size: 16px;
        }
        .notification li.info span.badge {
            background: #00c0ef;
        }
        .notification li.warning span.badge {
            background: #f39c12;
        }
        .notification li.success span.badge {
            background: #00a65a;
        }
        .notification li.error span.badge {
            background: #dd4b39;
        }
        .total_bal {
            margin-top: 5px;
            margin-right: 5%;
        }
        /* Custom Hover Zoom micro-animations */
        .dashboard-grid-card {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dashboard-grid-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(11, 94, 215, 0.08) !important;
        }
    </style>
@endsection

@section('pageContent')
    <!-- Main content -->
    <section class="content" style="background: transparent !important; padding: 24px !important; font-family: 'Poppins', sans-serif;">
        
        <!-- Header Title & Action Buttons -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-family: 'Poppins', sans-serif; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="font-size: 24px; font-weight: 700; color: #1a1a2e; margin: 0 0 4px 0;">School Management Dashboard</h2>
                <p style="font-size: 13px; color: #9ca3af; margin: 0;">System-wide overview · Active session metrics</p>
            </div>
            <div style="display: flex; gap: 12px;">
                @can('finance.term.index')
                <a href="{{ URL::route('finance.term.index') }}" class="btn" style="background: #0B5ED7; color: #ffffff !important; border-radius: 8px; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 8px 16px; border: none;">
                    <i class="fa fa-calendar"></i> Terms
                </a>
                @endcan
                <a href="#" class="btn" style="background: #ffffff; border: 1px solid #e2e8f0; color: #6b7280 !important; border-radius: 8px; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 8px 16px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <i class="fa fa-download"></i> Export Data
                </a>
            </div>
        </div>

        @if($userRoleId == AppHelper::USER_ADMIN)
            <!-- 4 Stats Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; font-family: 'Poppins', sans-serif;">
                
                <!-- Card 1: Students (Solid Blue) -->
                <a href="{{URL::route('student.index')}}" style="text-decoration: none !important;">
                    <div class="dashboard-grid-card" style="background: #0B5ED7; color: #ffffff; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 25px rgba(11, 94, 215, 0.15);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                            <span style="font-size: 13px; font-weight: 500;">Students</span>
                            <i class="fa icon-student" style="font-size: 18px; opacity: 0.9;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 28px; font-weight: 700; margin: 0 0 2px 0; line-height: 1.1; color: #ffffff !important;">{{$students}}</h3>
                            <span style="font-size: 11px; opacity: 0.85;">Total registered</span>
                        </div>
                    </div>
                </a>

                <!-- Card 2: Teachers (White) -->
                <a href="{{URL::route('teacher.index')}}" style="text-decoration: none !important;">
                    <div class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); color: #1a1a2e; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                            <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Teachers</span>
                            <i class="fa icon-teacher" style="font-size: 18px; color: #9ca3af;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 28px; font-weight: 700; margin: 0 0 2px 0; line-height: 1.1; color: #1a1a2e !important;">{{$teachers}}</h3>
                            <span style="font-size: 11px; color: #9ca3af;">Academic staff</span>
                        </div>
                    </div>
                </a>

                <!-- Card 3: Employees (White) -->
                <a href="{{URL::route('hrm.employee.index')}}" style="text-decoration: none !important;">
                    <div class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); color: #1a1a2e; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                            <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Employees</span>
                            <i class="fa icon-member" style="font-size: 18px; color: #9ca3af;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 28px; font-weight: 700; margin: 0 0 2px 0; line-height: 1.1; color: #1a1a2e !important;">{{$employee}}</h3>
                            <span style="font-size: 11px; color: #9ca3af;">Non-academic staff</span>
                        </div>
                    </div>
                </a>

                <!-- Card 4: Subjects (White) -->
                <a href="{{URL::route('academic.subject')}}" style="text-decoration: none !important;">
                    <div class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); color: #1a1a2e; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                            <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Subjects</span>
                            <i class="fa icon-subject" style="font-size: 18px; color: #9ca3af;"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 28px; font-weight: 700; margin: 0 0 2px 0; line-height: 1.1; color: #1a1a2e !important;">{{$subjects}}</h3>
                            <span style="font-size: 11px; color: #9ca3af;">Active courses</span>
                        </div>
                    </div>
                </a>

            </div>
        @endif

        <!-- 4 Quick Actions Grid -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; font-family: 'Poppins', sans-serif;">
            @can('student.index')
            <a href="{{ URL::route('student.index') }}" class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); padding: 18px 20px; border-radius: 16px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03); display: flex; align-items: center; gap: 15px; cursor: pointer; text-decoration: none !important;">
                <div style="width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: #E3F3FF; color: #0B5ED7;">
                    <i class="fa icon-student"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; margin: 0; color: #1a1a2e;">Manage Students</h4>
                    <span style="font-size: 11px; color: #9ca3af; margin-top: 2px; display: block;">View profiles</span>
                </div>
            </a>
            @endcan

            @can('teacher.index')
            <a href="{{ URL::route('teacher.index') }}" class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); padding: 18px 20px; border-radius: 16px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03); display: flex; align-items: center; gap: 15px; cursor: pointer; text-decoration: none !important;">
                <div style="width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: #ecfdf5; color: #047857;">
                    <i class="fa icon-teacher"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; margin: 0; color: #1a1a2e;">Manage Staff</h4>
                    <span style="font-size: 11px; color: #9ca3af; margin-top: 2px; display: block;">Faculty registry</span>
                </div>
            </a>
            @endcan

            @can('finance.payment.wizard')
            <a href="{{ URL::route('finance.payment.wizard') }}" class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); padding: 18px 20px; border-radius: 16px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03); display: flex; align-items: center; gap: 15px; cursor: pointer; text-decoration: none !important;">
                <div style="width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: #f5f3ff; color: #6d28d9;">
                    <i class="fa fa-credit-card"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; margin: 0; color: #1a1a2e;">Collect Payment</h4>
                    <span style="font-size: 11px; color: #9ca3af; margin-top: 2px; display: block;">Collect fees</span>
                </div>
            </a>
            @endcan

            @can('settings.institute')
            <a href="{{ URL::route('settings.institute') }}" class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); padding: 18px 20px; border-radius: 16px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03); display: flex; align-items: center; gap: 15px; cursor: pointer; text-decoration: none !important;">
                <div style="width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; background: #fff7ed; color: #ea580c;">
                    <i class="fa fa-cogs"></i>
                </div>
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; margin: 0; color: #1a1a2e;">Settings</h4>
                    <span style="font-size: 11px; color: #9ca3af; margin-top: 2px; display: block;">Institute configs</span>
                </div>
            </a>
            @endcan
        </div>

        @if($financeKpis && in_array($userRoleId, [AppHelper::USER_ADMIN, AppHelper::USER_ACCOUNTANT]))
            <!-- Finance KPI Stats Cards -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; font-family: 'Poppins', sans-serif;">
                
                <!-- Card 1: Revenue Today -->
                <div class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); color: #1a1a2e; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                        <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Revenue Today</span>
                        <i class="fa fa-money" style="font-size: 18px; color: #0d9488;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #1a1a2e !important;">{{ number_format($financeKpis['revenue_today'], 2) }}</h3>
                        <span style="font-size: 11px; color: #9ca3af;">Today's income</span>
                    </div>
                </div>

                <!-- Card 2: Revenue Month -->
                <div class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); color: #1a1a2e; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                        <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Revenue (Month)</span>
                        <i class="fa fa-line-chart" style="font-size: 18px; color: #db2777;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #1a1a2e !important;">{{ number_format($financeKpis['revenue_month'], 2) }}</h3>
                        <span style="font-size: 11px; color: #9ca3af;">This month's total</span>
                    </div>
                </div>

                <!-- Card 3: Expenses Month -->
                <div class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); color: #1a1a2e; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                        <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Expenses (Month)</span>
                        <i class="fa fa-shopping-cart" style="font-size: 18px; color: #9333ea;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #1a1a2e !important;">{{ number_format($financeKpis['expenses_month'], 2) }}</h3>
                        <span style="font-size: 11px; color: #9ca3af;">This month's expenses</span>
                    </div>
                </div>

                <!-- Card 4: Outstanding Arrears -->
                <div class="dashboard-grid-card" style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); color: #1a1a2e; border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; height: 115px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%;">
                        <span style="font-size: 13px; font-weight: 500; color: #6b7280;">Outstanding Arrears</span>
                        <i class="fa fa-exclamation-circle" style="font-size: 18px; color: #f97316;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #1a1a2e !important;">{{ number_format($financeKpis['outstanding_arrears'], 2) }}</h3>
                        <span style="font-size: 11px; color: #9ca3af;">Pending receivables</span>
                    </div>
                </div>

            </div>

            <!-- Finance Chart Boxes -->
            <div class="row">
                <div class="col-md-8">
                    <div class="box box-info" style="border: 1px solid rgba(11, 94, 215, 0.06) !important; border-radius: 16px !important; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03) !important; background: #ffffff !important; overflow: hidden; margin-bottom: 24px;">
                        <div class="box-header with-border" style="border-bottom: 1px solid rgba(11, 94, 215, 0.06) !important; padding: 18px 24px !important; background: transparent;">
                            <h3 style="margin: 0 !important; font-size: 16px !important; font-weight: 600; color: #1a1a2e; font-family: 'Poppins', sans-serif;">Revenue vs Expenses</h3>
                        </div>
                        <div class="box-body" style="padding: 24px !important;">
                            <canvas id="financeDashboardTrend" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-info" style="border: 1px solid rgba(11, 94, 215, 0.06) !important; border-radius: 16px !important; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03) !important; background: #ffffff !important; overflow: hidden; margin-bottom: 24px;">
                        <div class="box-header with-border" style="border-bottom: 1px solid rgba(11, 94, 215, 0.06) !important; padding: 18px 24px !important; background: transparent;">
                            <h3 style="margin: 0 !important; font-size: 16px !important; font-weight: 600; color: #1a1a2e; font-family: 'Poppins', sans-serif;">Expenses by Category</h3>
                        </div>
                        <div class="box-body" style="padding: 24px !important;">
                            <canvas id="financeDashboardCategory" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($userRoleId != AppHelper::USER_STUDENT)
            <!-- Attendance Chart Box -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info" style="border: 1px solid rgba(11, 94, 215, 0.06) !important; border-radius: 16px !important; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03) !important; background: #ffffff !important; overflow: hidden; margin-bottom: 24px;">
                        <div class="box-header with-border" style="border-bottom: 1px solid rgba(11, 94, 215, 0.06) !important; padding: 18px 24px !important; display: flex; justify-content: space-between; align-items: center; background: transparent;">
                            <h3 style="margin: 0 !important; font-size: 16px !important; font-weight: 600; color: #1a1a2e; font-family: 'Poppins', sans-serif;">Students Today's Attendance</h3>
                        </div>
                        <div class="box-body" style="padding: 24px !important;">
                            <canvas id="attendanceChart" style="height: 180px; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($userRoleId == AppHelper::USER_STUDENT)
            <!-- Student Portal Welcome Section -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div style="background: #ffffff; border: 1px solid rgba(11, 94, 215, 0.06); padding: 30px; border-radius: 16px; box-shadow: 0 8px 20px rgba(11, 94, 215, 0.03); text-align: center; font-family: 'Poppins', sans-serif;">
                        <div style="width: 54px; height: 54px; border-radius: 50%; background: #ecfdf5; color: #047857; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px;">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <h3 style="font-size: 20px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0;">Welcome to Student Portal</h3>
                        <p style="font-size: 13px; color: #6b7280; margin: 0 0 20px 0; line-height: 1.5;">Manage your academic records, check grades, track attendance, and more from your portal dashboard.</p>
                        <a href="{{ URL::route('public.student_profile') }}" style="background: #0B5ED7; color: #ffffff !important; border-radius: 8px; font-size: 13px; font-weight: 600; padding: 10px 20px; text-decoration: none; display: inline-block;">View Profile</a>
                    </div>
                </div>
            </div>
        @endif

    </section>
@endsection

@section('extraScript')
    <script src="{{asset(mix('js/dashboard.js'))}}"></script>
    @if($financeKpis && in_array($userRoleId, [AppHelper::USER_ADMIN, AppHelper::USER_ACCOUNTANT]))
    <script src="{{ asset(mix('js/finance.js')) }}"></script>
    @endif
    <script type="text/javascript">
        @if($userRoleId != AppHelper::USER_STUDENT)
            window.attendanceLabel = @php echo json_encode(array_keys($attendanceChartPresentData)) @endphp;
            window.presentData = @php echo json_encode(array_values($attendanceChartPresentData)) @endphp;
            window.absentData = @php echo json_encode(array_values($attendanceChartAbsentData)) @endphp;
        @endif

        @if($financeChartData && in_array($userRoleId, [AppHelper::USER_ADMIN, AppHelper::USER_ACCOUNTANT]))
            window.financeDashboardTrendLabels = @json($financeChartData['trend_labels']);
            window.financeDashboardRevenue = @json($financeChartData['revenue']);
            window.financeDashboardExpenses = @json($financeChartData['expenses']);
            window.financeDashboardCategoryLabels = @json($financeChartData['category_labels']);
            window.financeDashboardCategoryData = @json($financeChartData['category_data']);
        @endif

        $(document).ready(function () {
            Dashboard.init();
            @if($financeChartData && in_array($userRoleId, [AppHelper::USER_ADMIN, AppHelper::USER_ACCOUNTANT]))
            if (typeof Finance !== 'undefined') {
                Finance.dashboardInit();
            }
            @endif
        });
    </script>
@endsection
