  <aside id="asideBar">
      <ul>
          <li>
              <a href="{{ route('provider.dashboard') }}">
                  <span>لوحة التحكم</span>
                  <i class="fa-regular fa-house"></i>
              </a>
          </li>
          <li>
              <a href="{{ route('provider.project.index') }}">
                  <span>المشاريع المتاحة</span>
                  <i class="fa-regular fa-folder-open"></i>
              </a>
          </li>
          <li>
              <a href="{{ route('provider.offers.index') }}">
                  <span>عروضي المقدمة</span>
                  <i class="fa-solid fa-briefcase"></i>
              </a>
          </li>
          <li class="drodown">
            {{--  Add   to a for show  drodown_mune--}}
              <a   href="{{route('provider.project.in.progress')}}" >
                    <i class="angle  fa-solid fa-angle-{{ request()->routeIs('provider.project.in.progress') ? "up" : "down" }}"></i>
                    <span>تنفيذ المشاريع</span>
                    <i class="fa-regular fa-building"></i>
              </a>
              <ul class="drodown_mune {{ request()->routeIs('provider.project.in.progress') ? "show" : "" }}" id="dropdown_menu">
                @foreach (Auth::guard('provider')->user()->activeProjects() as $item)
                      <li><a href="{{ route('provider.project.implementation.index' , $item->id) }}"> #{{ $item->id }} - {{ $item->serviceType->name }}
                              {{ $item->buildingType->name }}</a></li>
                  @endforeach
              </ul>
          </li>
          <li>
              <a href="{{route('provider.payments.index')}}">
                  <span>المدفوعات</span>
                  <i class="fa-regular fa-credit-card"></i>
              </a>
          </li>
            <li>
                <a href="{{ route('provider.discounts.index') }}">
                    <span>عروض شركائنا</span>
                    <i class="fa-regular fa-handshake"></i>
                </a>
            </li>
          <li>
            
              <a href="{{ route("provider.profile.index") }}">
                  <span>الملف الشخصي</span>
                  <i class="fa-regular fa-user"></i>
              </a>
          </li>
          <li>
              <a href="{{ route('provider.notifications.index') }}">
                  <span>الإشعارات </span>
                  <div class="notification_iocn">
                        <span>{{auth('provider')->user()->notifications()->where('seen' , 0)->count()}}</span>
                        <i class="fa-regular fa-bell"></i>
                  </div>
              </a>
          </li>
          {{-- <li>
              <a href="#">
                  <span>الإعدادات</span>
                  <i class="fa-solid fa-gear"></i>
              </a>
          </li> --}}
      </ul>

       <a class="logout text-center" href="{{ route('provider.logout') }}">
           <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>تسجيل الخروج</span>
        </a>
  </aside>
