<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn">
	<i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">
	<!-- BEGIN: Aside Menu -->
	<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<li class="m-menu__section m-menu__section--first">
				<h4 class="m-menu__section-text">
					Разделы
				</h4>
				<i class="m-menu__section-icon flaticon-more-v3"></i>
			</li>
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon jam jam-users"></i>
					<span class="m-menu__link-text">
						Сотрудники
					</span>
					<i class="m-menu__ver-arrow jam jam-chevron-right"></i>
				</a>
				<div class="m-menu__submenu">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
							<span class="m-menu__link">
								<span class="m-menu__link-text">
									Сотрудники
								</span>
							</span>
						</li>
						<li class="m-menu__item " aria-haspopup="true" >
							<a  href="{{route('users.index')}}" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Список сотрудников
								</span>
							</a>
						</li>
						@if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
							<li class="m-menu__item " aria-haspopup="true"  m-menu-link-redirect="1">
								<a  href="{{route('userTypes.index')}}" class="m-menu__link ">
									<i class="m-menu__link-bullet m-menu__link-bullet--dot">
										<span></span>
									</i>
									<span class="m-menu__link-text">
									Должности
								</span>
								</a>
							</li>
						@endif
					</ul>
				</div>
			</li>
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon jam jam-ticket"></i>
					<span class="m-menu__link-text">
						Лотерея
					</span>
					<i class="m-menu__ver-arrow jam jam-chevron-right"></i>
				</a>
				<div class="m-menu__submenu">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
							<span class="m-menu__link">
								<span class="m-menu__link-text">
									Лотерея
								</span>
							</span>
						</li>
						<li class="m-menu__item " aria-haspopup="true" >
							<a  href="{{route('drawLottery.index')}}" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Тиражные лотереи
								</span>
							</a>
						</li>
						<li class="m-menu__item " aria-haspopup="true"  m-menu-link-redirect="1">
							<a  href="{{route('instantLottery.index')}}" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
								Мгновенные лотереи
							</span>
							</a>
						</li>
					</ul>
				</div>
			</li>
			@if((auth()->user()->isAdmin()) || (auth()->user()->isStock()))
				<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
					<a  href="javascript:;" class="m-menu__link m-menu__toggle">
						<i class="m-menu__link-icon jam jam-file"></i>
						<span class="m-menu__link-text">
							Отчеты
						</span>
						<i class="m-menu__ver-arrow jam jam-chevron-right"></i>
					</a>
					<div class="m-menu__submenu ">
						<span class="m-menu__arrow"></span>
						<ul class="m-menu__subnav">
							<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
								<span class="m-menu__link">
									<span class="m-menu__link-text">
										Отчеты
									</span>
								</span>
							</li>
							<li class="m-menu__item " aria-haspopup="true" >
								<a  href="{{route('reports.index')}}" class="m-menu__link ">
									<i class="m-menu__link-bullet m-menu__link-bullet--dot">
										<span></span>
									</i>
									<span class="m-menu__link-text">
										Все отчеты
									</span>
								</a>
							</li>
							<li class="m-menu__item " aria-haspopup="true" >
								<a  href="{{route('reports.create')}}" class="m-menu__link ">
									<i class="m-menu__link-bullet m-menu__link-bullet--dot">
										<span></span>
									</i>
									<span class="m-menu__link-text">
										Создать отчет
									</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
			@endif
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a  href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon jam jam-cog"></i>
					<span class="m-menu__link-text">
						Настройки
					</span>
					<i class="m-menu__ver-arrow jam jam-chevron-right"></i>
				</a>
				<div class="m-menu__submenu ">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
							<span class="m-menu__link">
								<span class="m-menu__link-text">
									Настройки
								</span>
							</span>
						</li>
						<li class="m-menu__item " aria-haspopup="true" >
							<a  href="{{route('settings.bySlug', 'tickets')}}" class="m-menu__link ">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot">
									<span></span>
								</i>
								<span class="m-menu__link-text">
									Оформление билетов
								</span>
							</a>
						</li>						
					</ul>
				</div>
			</li>
		</ul>
	</div>
	<!-- END: Aside Menu -->
</div>