<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:void(0);" class="brand-link text-center">
        <span class="brand-text font-weight-bold">School</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ !empty(Auth::user()->image) ? asset('uploads/user/' . Auth::user()->image) : asset('admin-assets/dist/img/avatar5.png') }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0);" class="d-block">{{ Auth::guard('web')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                @if (Auth::user()->getOriginal('role') == 1)
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link @yield('dashboard')">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.admins.index') }}" class="nav-link @yield('admins')">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Admins</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.teacher.index') }}" class="nav-link @yield('teacher')">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Teachers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.student.index') }}" class="nav-link @yield('student')">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Students</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.parent.index') }}" class="nav-link @yield('parent')">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Parents</p>
                        </a>
                    </li>
                    <li class="nav-item @yield('academic_open')">
                        <a href="#" class="nav-link @yield('academic_active')">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Academics
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.class.index') }}" class="nav-link @yield('class')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Classes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.subject.index') }}" class="nav-link @yield('subject')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subjects</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.assign_subject.index') }}" class="nav-link @yield('assign_subject')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Assign Subjects</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.class_timetable.index') }}"
                                    class="nav-link @yield('class_timetable')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Class Timetable</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.assign_class_teacher.index') }}"
                                    class="nav-link @yield('assign_class_teacher')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Assign Class To Teacher</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item @yield('exam_open')">
                        <a href="#" class="nav-link @yield('exam_active')">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Examination
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.exam.index') }}" class="nav-link @yield('exam')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Exam</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.exam_schedule.index') }}" class="nav-link @yield('exam_schedule')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Exam Schedule</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.exam.marks_register') }}" class="nav-link @yield('marks_register')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Marks Register</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.marks_grade.index') }}" class="nav-link @yield('marks_grade')">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Marks Grade</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::user()->getOriginal('role') == 2)
                    <li class="nav-item">
                        <a href="{{ route('teacher.dashboard') }}" class="nav-link @yield('dashboard')">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teacher.my_student') }}" class="nav-link @yield('my_student')">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>My Student</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teacher.my_class_subject') }}" class="nav-link @yield('my_class_subject')">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>My Class & Subject</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teacher.exam_timetable') }}" class="nav-link @yield('exam_timetable')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Exam Timetable</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teacher.calendar') }}" class="nav-link @yield('calendar')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Calender</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teacher.marks_register') }}" class="nav-link @yield('marks_register')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Marks Register</p>
                        </a>
                    </li>
                @elseif(Auth::user()->getOriginal('role') == 3)
                    <li class="nav-item">
                        <a href="{{ route('student.dashboard') }}" class="nav-link @yield('dashboard')">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.subject') }}" class="nav-link @yield('subject')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Subjects</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.calendar') }}" class="nav-link @yield('calendar')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Calender</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.timetable') }}" class="nav-link @yield('timetable')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Timetable</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.exam_timetable') }}" class="nav-link @yield('exam_timetable')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Exam Timetable</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.exam_result') }}" class="nav-link @yield('exam_result')">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Exam Result</p>
                        </a>
                    </li>
                @elseif(Auth::user()->getOriginal('role') == 4)
                    <li class="nav-item">
                        <a href="{{ route('parent.dashboard') }}" class="nav-link @yield('dashboard')">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('parent.children') }}" class="nav-link @yield('children')">
                            <i class="nav-icon fas fa-user-alt"></i>
                            <p>My Childrens</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        this.closest('form').submit();"
                            class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
