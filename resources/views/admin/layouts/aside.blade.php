<aside id="asideBar">
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <span>لوحة التحكم</span>
                <i class="fa-solid fa-chart-pie"></i>
            </a>
        </li>
        {{-- العملاء (Customers) --}}
        @canany(['view customers', 'view customers.requests'])
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>العملاء</span>
                    <i class="fa-solid fa-users"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view customers')
                        <li><a href="{{ route('admin.customers.index') }}">قائمة العملاء</a></li>
                    @endcan
                    @can('view customers.requests')
                        <li><a href="{{ route('admin.customers.requests.index') }}">الطلبات</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- مزودو الخدمات (Providers) --}}
        @canany(['view providers', 'view providers.requests'])
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>مزودو الخدمات</span>
                    <i class="fa-solid fa-user-gear"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view providers')
                        <li><a href="{{ route('admin.providers.index') }}">قائمة المزودين</a></li>
                    @endcan
                    @can('view providers.requests')
                        <li><a href="{{ route('admin.providers.requests.index') }}">الطلبات</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- المشاريع (Projects) --}}
        @canany(['view projects.pending', 'view projects.active', 'view projects.completed'])
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>المشاريع</span>
                    <i class="fa-solid fa-diagram-project"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view projects.pending')
                        <li><a href="{{ route('admin.projects.pending.index') }}">معلقة</a></li>
                    @endcan
                    @can('view projects.active')
                        <li><a href="{{ route('admin.projects.active.index') }}">نشطة</a></li>
                    @endcan
                    @can('view projects.completed')
                        <li><a href="{{ route('admin.projects.completed.index') }}">مكتملة</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- المعاينات (Inspections) --}}
        @can('view inspections')
            <li>
                <a href="{{ route('admin.inspection.index') }}">
                    <span>المعاينات</span>
                    <i class="fa-solid fa-binoculars"></i>
                </a>
            </li>
        @endcan

        {{-- العروض (Offers) --}}
        @canany(['view offers.pending', 'view offers.active', 'view offers.completed', 'view offers.drafted'])
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>العروض</span>
                    <i class="fa-solid fa-briefcase"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view offers.pending')
                        <li><a href="{{ route('admin.offers.pending.index') }}">معلقة</a></li>
                    @endcan
                    @can('view offers.active')
                        <li><a href="{{ route('admin.offers.active.index') }}">نشطة</a></li>
                    @endcan
                    @can('view offers.completed')
                        <li><a href="{{ route('admin.offers.compeleted.index') }}">مكتملة</a></li>
                    @endcan
                    @can('view offers.drafted')
                        <li><a href="{{ route('admin.offers.drafted.index') }}">مسودة</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany

        {{-- المستخدمين والأدوار --}}
        @canany(['view users', 'view roles'])
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>المستخدمين والأدوار</span>
                    <i class="fa-solid fa-user-shield"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view users')
                        <li><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
                    @endcan
                    @can('view roles')
                        <li><a href="{{ route('admin.roles.index') }}">الأدوار</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['view resources', 'create resources' ,  'edit resources'] )
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>الموارد</span>
                    <i class="fa-regular fa-truck"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view resources')
                        <li><a href="{{ route('admin.reference.regions.index') }}">المناطق</a></li>
                    @endcan
                    @can('view resources')
                        <li><a href="{{ route('admin.reference.specialties.index') }}">الخدمات</a></li>
                    @endcan
                    @can('view resources')
                        <li><a href="{{ route('admin.reference.project-types.index') }}">انواع المشاريع</a></li>
                    @endcan
                    @can('view resources')
                        <li><a href="{{ route('admin.reference.categories.index') }}">اقسام المشاريع</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['view partners', 'create partners' , 'edit partners' , 'view partnersDiscounts', 'edit partnersDiscounts' , 'create partnersDiscounts'])
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>الشركاء</span>
                    <i class="fa-regular fa-handshake"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view partners')
                        <li><a href="{{ route('admin.partners.partners.index') }}">الشركاء</a></li>
                    @endcan
                    @can('view partners')
                        <li><a href="{{ route('admin.partners.sections.index') }}">الاقسام</a></li>
                    @endcan
                    @can('view partnersDiscounts')
                        <li><a href="{{ route('admin.partners.discounts.index') }}">العروض</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany
         @canany(['view ratings', 'edit ratings'])
            <li class="drodown">
                <a href="#" onclick="toggleDropdown(event)">
                    <span>التقييمات</span>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </a>
                <ul class="drodown_mune">
                    @can('view ratings')
                        <li><a href="{{ route('admin.ratings.customers.index') }}">العملاء</a></li>
                    @endcan
                    @can('view roles')
                        <li><a href="{{ route('admin.ratings.providers.index') }}">المزودين</a></li>
                    @endcan
                </ul>
            </li>
        @endcanany
          <li>
                <a href="{{route('admin.notifications.index')}}">
                    <span>الإشعارات </span>
                    <div class="notification_iocn">
                        <span>{{auth('admin')->user()->notifications()->where('seen' , 0)->count()}}</span>
                        <i class="fa-regular fa-bell"></i>
                    </div>
                </a>
            </li>
            @can('view settings')
                <li>
                    <a href="{{route('admin.settings.index')}}"> 
                        <span>الاعدادات </span>
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </li>
            @endcan
    </ul>

    {{-- تسجيل الخروج (Logout) --}}
    <a class="logout text-center" href="{{ route('admin.logout') }}">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
        <span>تسجيل الخروج</span>
    </a>
</aside>
