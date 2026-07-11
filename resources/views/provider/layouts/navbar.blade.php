  <header>

        <div class="left">
            <div class="logo">
                <img src="{{asset('assets\images\customer\logo.png')}}" alt="logo">
                <div class="text">
                    <h6>منصة المقاولين</h6>
                    <span>نظام إدارة شامل</span>
                </div>
            </div>
            <div class="icon_toggle_aside"  id="icon_toggle_aside">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 2L6 14M5.2 2L10.8 2C11.9201 2 12.4802 2 12.908 2.21799C13.2843 2.40973 13.5903 2.71569 13.782 3.09202C14 3.51984 14 4.0799 14 5.2L14 10.8C14 11.9201 14 12.4802 13.782 12.908C13.5903 13.2843 13.2843 13.5903 12.908 13.782C12.4802 14 11.9201 14 10.8 14L5.2 14C4.07989 14 3.51984 14 3.09202 13.782C2.71569 13.5903 2.40973 13.2843 2.21799 12.908C2 12.4802 2 11.9201 2 10.8L2 5.2C2 4.07989 2 3.51984 2.21799 3.09202C2.40973 2.71569 2.71569 2.40973 3.09202 2.21799C3.51984 2 4.0799 2 5.2 2Z" stroke="#111111" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>      
            </div>
            <div class="input_group">
                {{-- <input type="search" name="project-search" placeholder="البحث في المشاريع والعروض...">
                <div class="search_icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div> --}}
            </div>
        </div>

        <div class="right">
           

            <div class="user" id="userMenu">
                <div class="userimg">
                    <img src="{{ auth('provider')->user()->image ? Storage::url( auth('provider')->user()->image) : '/assets/images/home/user.png' }}"  width="20" height="20" alt="">
                </div>
                <a href="#" class="name">
                    <h6>{{ auth('provider')->user()->company_name }}</h6>
                    <p class="email">{{ auth('provider')->user()->email }}</p>
                </a>
                <div class="icon" id="userToggle">
                    <i class="fa-solid fa-angle-down"></i>
                </div>

                <div class="logout_dropdown" id="userDropdown">
                    <a href="{{ route('provider.logout') }}">
                        <button type="submit" class="logout-btn">
                            تسجيل الخروج
                        </button>
                    </a>
                </div>

            </div>
        </div>

    </header>



    
<script>
    const toggle = document.getElementById('userToggle');
    const dropdown = document.getElementById('userDropdown');

    toggle.addEventListener('click', () => {
        dropdown.classList.toggle('active');
    });
    
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#userMenu')) {
            dropdown.classList.remove('active');
        }
    });
</script>