  <aside id="asideBar" >
        <ul>
            <li>
                <a href="{{ route('customer.dashboard') }}">
                    <span>لوحة التحكم</span>
                    <i class="fa-regular fa-house"></i>
                </a>
            </li>
            <li>
                <a href="{{route('customer.project.index')}}">
                    <span>مشاريعي</span>
                    <i class="fa-regular fa-folder-open"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.payments.index') }}">
                    <span>المدفوعات</span>
                    <i class="fa-regular fa-credit-card"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.discounts.index') }}">
                    <span>عروض شركائنا</span>
                    <i class="fa-regular fa-handshake"></i>
                </a>
            </li>
            <li>
                <a href="{{route('customer.notifications.index')}}">
                    <span>الإشعارات </span>
                    <div class="notification_iocn">
                        <span>{{auth('customer')->user()->notifications()->where('seen' , 0)->count()}}</span>
                        <i class="fa-regular fa-bell"></i>
                    </div>
                </a>
            </li>
        </ul>

        <a class="logout text-center" href="{{ route('customer.logout') }}">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>تسجيل الخروج</span>
        </a>
    </aside>

