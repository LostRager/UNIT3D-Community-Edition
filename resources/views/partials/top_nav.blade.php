<nav class="top-nav" x-data="{ expanded: false }" x-bind:class="expanded && 'mobile'">
    <div class="top-nav__left">
        <a class="top-nav__branding" href="{{ route('home.index') }}">
            <i class="fal fa-tv-retro"></i>
            <span class="top-nav__site-logo">{{ \config('other.title') }}</span>
        </a>
        <livewire:quick-search-dropdown />
    </div>
    <ul class="top-nav__main-menus" x-bind:class="expanded && 'mobile'">
        <li class="top-nav--left__list-item top-nav__dropdown">
            <a
                class="top-nav__dropdown--nontouch"
                href="{{ route('torrents.index', ['view' => match(auth()->user()->torrent_layout) {
                    1       => 'card',
                    2       => 'group',
                    3       => 'poster',
                    default => 'list'
                }]) }}"
            >
                <div class="top-nav--left__container">
                    {{ __('torrent.torrents') }}
                </div>
            </a>
            <a class="top-nav__dropdown--touch" tabindex="0">
                <div class="top-nav--left__container">
                    {{ __('torrent.torrents') }}
                </div>
            </a>
            <ul>
                <li>
                    <a
                        href="{{ route('torrents.index', ['view' => match(auth()->user()->torrent_layout) {
                            1       => 'card',
                            2       => 'group',
                            3       => 'poster',
                            default => 'list'
                        }]) }}"
                    >
                        <i class="{{ config('other.font-awesome') }} fa-download"></i>
                        {{ __('torrent.torrents') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('torrents.create', ['category_id' => 1]) }}">
                        <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                        {{ __('common.upload') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('requests.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-hands-helping"></i>
                        {{ __('request.requests') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('rss.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-rss"></i>
                        {{ __('rss.rss') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('mediahub.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-database"></i>
                        MediaHub
                    </a>
                </li>
            </ul>
        </li>
        <li class="top-nav--left__list-item top-nav__dropdown">
            <a class="top-nav__dropdown--nontouch"  href="{{ route('forums.index') }}">
                <div class="top-nav--left__container">
                    {{ __('common.community') }}
                </div>
            </a>
            <a class="top-nav__dropdown--touch" tabindex="0">
                <div class="top-nav--left__container">
                    {{ __('common.community') }}
                </div>
            </a>
            <ul>
                <li>
                    <a  href="{{ route('forums.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-comments"></i>
                        {{ __('forum.forums') }}
                    </a>
                </li>
                <li>
                    <a  href="{{ route('playlists.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-list-ol"></i>
                        {{ __('playlist.playlists') }}
                    </a>
                </li>
                <li>
                    <a  href="{{ route('polls.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-chart-pie"></i>
                        {{ __('poll.polls') }}
                    </a>
                </li>
                <li>
                    <a  href="{{ route('stats') }}">
                        <i class="{{ config('other.font-awesome') }} fa-chart-bar"></i>
                        {{ __('common.extra-stats') }}
                    </a>
                </li>
                <li>
                    <a  href="{{ route('articles.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-newspaper"></i>
                        {{ __('common.news') }}
                    </a>
                </li>
                @if (!empty(config('unit3d.chat-link-url')))
                    <li>
                        <a  href="{{ config('unit3d.chat-link-url') }}">
                            <i class="{{ config('unit3d.chat-link-icon') }}"></i>
                            {{ config('unit3d.chat-link-name') ?: __('common.chat') }}
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="top-nav__dropdown">
            <a tabindex="0">
                <div class="top-nav--left__container">
                    {{ __('common.support') }}
                    <!-- Notifications for Mods -->
                    @if (auth()->user()->group->is_modo)
                        @php
                            $tickets = DB::table('tickets')
                                ->whereNull('closed_at')->whereNull('staff_id')
                                ->orwhere(function($query) {
                                    $query
                                        ->where('staff_id', '=', auth()->id())
                                        ->Where('staff_read', '=', '0');
                                })
                                ->exists()
                        @endphp
                        @if ($tickets)
                            <x-animation.notification />
                        @endif
                    <!-- Notification for Users -->
                    @else
                        @php
                            $ticket_unread = DB::table('tickets')
                                ->where('user_id', '=', auth()->id())
                                ->where('user_read', '=', '0')
                                ->exists()
                        @endphp
                        @if ($ticket_unread)
                            <x-animation.notification />
                        @endif
                    @endif
                </div>
            </a>
            <ul>
                <li>
                    <a href="{{ config('other.rules_url') }}">
                        <i class="{{ config('other.font-awesome') }} fa-info"></i>
                        {{ __('common.rules') }}
                    </a>
                </li>
                <li>
                    <a href="{{ config('other.faq_url') }}">
                        <i class="{{ config('other.font-awesome') }} fa-question"></i>
                        {{ __('common.faq') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('tickets.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-life-ring"></i>
                        {{ __('ticket.helpdesk') }}
                        <!-- Notifications for Mods -->
                        @if (auth()->user()->group->is_modo)
                            @if ($tickets > 0)
                                <x-animation.notification />
                            @endif
                        <!-- Notification for Users -->
                        @else
                            @if ($ticket_unread > 0)
                                <x-animation.notification />
                            @endif
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff') }}">
                        <i class="{{ config('other.font-awesome') }} fa-user-secret"></i>
                        {{ __('common.staff') }}
                    </a>
                </li>
            </ul>
        </li>
        <li class="top-nav__dropdown">
            <a tabindex="0">
                <div class="top-nav--left__container">
                    {{ __('common.other') }}
                </div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('subtitles.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-closed-captioning"></i>
                        {{ __('common.subtitles') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('top10.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-trophy-alt"></i>
                        {{ __('common.top-10') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('missing.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-ballot-check"></i>
                        {{ __('common.missing') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('internal') }}">
                        <i class="{{ config('other.font-awesome') }} fa-star-shooting"></i>
                        {{ __('common.internal') }}
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="top-nav__right" x-bind:class="expanded && 'mobile'">
        <ul class="top-nav__stats" x-bind:class="expanded && 'mobile'">
            <li class="top-nav__stats-up" title="{{ __('common.upload') }}">
                <i class="{{ config('other.font-awesome') }} fa-arrow-up text-green"></i>
                {{ auth()->user()->formatted_uploaded }}
            </li>
            <li class="top-nav__stats-down" title="{{ __('common.download') }}">
                <i class="{{ config('other.font-awesome') }} fa-arrow-down text-red"></i>
                {{ auth()->user()->formatted_downloaded }}
            </li>
            <li class="top-nav__stats-ratio" title="{{ __('common.ratio') }}">
                <i class="{{ config('other.font-awesome') }} fa-sync-alt text-blue"></i>
                {{ auth()->user()->formatted_ratio }}
            </li>
        </ul> 
        <ul class="top-nav__ratio-bar" x-bind:class="expanded && 'mobile'">
            <li class="ratio-bar__uploaded" title="{{ __('common.upload') }}">
                <a href="{{ route('users.torrents.index', ['user' => auth()->user()]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-up"></i>
                    {{ auth()->user()->formatted_uploaded }}
                </a>
            </li>
            <li class="ratio-bar__downloaded" title="{{ __('common.download') }}">
                <a href="{{ route('users.history.index', ['user' => auth()->user(), 'downloaded' => 'include']) }}">
                    <i class="{{ config('other.font-awesome') }} fa-arrow-down"></i>
                    {{ auth()->user()->formatted_downloaded }}
                </a>
            </li>
            @php
                // Generally sites have more seeders than leechers, so it ends up being faster (by approximately 50%) to compute these stats instead of computing them individually
                $peer_count = Cache::remember(
                    'users:'.auth()->id().':peer_count',
                    60,
                    fn () => DB::table('peers')->where('user_id', '=', auth()->id())->where('active', '=', 1)->count() ?? 0
                );
                $leech_count = Cache::remember(
                    'users:'.auth()->id().':leech_count',
                    60,
                    fn () => DB::table('peers')->where('seeder', '=', false)->where('user_id', '=', auth()->id())->where('active', '=', 1)->count() ?? 0
                )
            @endphp
            <li class="ratio-bar__seeding" title="{{ __('torrent.seeding') }}">
                <a href="{{ route('users.peers.index', ['user' => auth()->user()]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                    {{ $peer_count - $leech_count }}
                </a>
            </li>
            <li class="ratio-bar__leeching" title="{{ __('torrent.leeching') }}">
                <a href="{{ route('users.peers.index', ['user' => auth()->user(), 'seeding' => 'exclude']) }}">
                    <i class="{{ config('other.font-awesome') }} fa-download"></i>
                    {{ $leech_count }}
                </a>
            </li>
            <li class="ratio-bar__buffer" title="{{ __('common.buffer') }}">
                <a href="{{ route('users.history.index', ['user' => auth()->user()]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-exchange"></i>
                    {{ auth()->user()->formatted_buffer }}
                </a>
            </li>
            <li class="ratio-bar__points" title="{{ __('user.my-bonus-points') }}">
                <a href="{{ route('users.earnings.index', ['user' => auth()->user()]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-coins" ></i>
                    {{ auth()->user()->formatted_seedbonus }}
                </a>
            </li>
            <li class="ratio-bar__ratio" title="{{ __('common.ratio') }}">
                <a href="{{ route('users.history.index', ['user' => auth()->user()]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-sync-alt"></i>
                    {{ auth()->user()->formatted_ratio }}
                </a>
            </li>
            <li class="ratio-bar__tokens" title="{{ __('user.my-fl-tokens') }}">
                <a href="{{ route('users.show', ['user' => auth()->user()]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-star"></i>
                    {{ auth()->user()->fl_tokens }}
                </a>
            </li>
        </ul> 
        <a class="top-nav__username--highresolution" href="{{ route('users.show', ['user' => auth()->user()]) }}">
            <span class="text-bold" style="color:{{ auth()->user()->group->color }}; background-image:{{ auth()->user()->group->effect }};">
                <i class="{{ auth()->user()->group->icon }}"></i>
                {{ auth()->user()->username }}
                @if (auth()->user()->warnings()->active()->exists())
                    <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-orange"
                        title="{{ __('common.active-warning') }}"></i>
                @endif
            </span>
        </a>
        <ul class="top-nav__icon-bar" x-bind:class="expanded && 'mobile'">
            @if (auth()->user()->group->is_modo)
                <li>
                    <a class="top-nav--right__icon-link" href="{{ route('staff.dashboard.index') }}" title="{{ __('staff.staff-dashboard') }}">
                        <i class="{{ config('other.font-awesome') }} fa-cogs"></i>
                    </a>
                </li>
            @endif
            @if (auth()->user()->group->is_modo)
                <li>
                    <a class="top-nav--right__icon-link" href="{{ route('staff.moderation.index') }}" title="{{ __('staff.torrent-moderation') }}">
                        <i class="{{ config('other.font-awesome') }} fa-tasks"></i>
                        @php
                            $torrents_unmoderated = DB::table('torrents')->where('status', '=', \App\Models\Torrent::PENDING)->exists()
                        @endphp
                        @if ($torrents_unmoderated)
                            <x-animation.notification />
                        @endif
                    </a>
                </li>
            @endif
            <li>
                @php
                    $pm = DB::table('private_messages')
                        ->where('receiver_id', '=', auth()->id())
                        ->where('read', '=', '0')
                        ->exists()
                @endphp
                <a class="top-nav--right__icon-link" href="{{ route('users.received_messages.index', ['user' => auth()->user()]) }}" title="{{ __('pm.inbox') }}">
                    <i class="{{ config('other.font-awesome') }} fa-envelope"></i>
                    @if ($pm)
                        <x-animation.notification />
                    @endif
                </a>
            </li>
            <li>
                <a class="top-nav--right__icon-link" href="{{ route('users.notifications.index', ['user' => auth()->user()]) }}" title="{{ __('user.notifications') }}">
                    <i class="{{ config('other.font-awesome') }} fa-bell"></i>
                    @if (auth()->user()->unreadNotifications()->exists())
                        <x-animation.notification />
                    @endif
                </a>
            </li>
            <li class="top-nav__dropdown">
                <a class="top-nav__dropdown--nontouch" href="{{ route('users.show', ['user' => auth()->user()]) }}">
                    <img
                        src="{{ url(auth()->user()->image ? 'files/img/'.auth()->user()->image : 'img/profile.png')}}"
                        alt="{{ auth()->user()->username }}"
                        class="top-nav__profile-image"
                    >
                </a>
                <a class="top-nav__dropdown--touch" tabindex="0">
                    <img
                        src="{{ url(auth()->user()->image ? 'files/img/'.auth()->user()->image : 'img/profile.png')}}"
                        alt="{{ auth()->user()->username }}"
                        class="top-nav__profile-image"
                    >
                </a>
                <ul>
                    <li>
                        <a class="top-nav__username" href="{{ route('users.show', ['user' => auth()->user()]) }}">
                            <span class="text-bold" style="color:{{ auth()->user()->group->color }}; background-image:{{ auth()->user()->group->effect }};">
                                <i class="{{ auth()->user()->group->icon }}"></i>
                                {{ auth()->user()->username }}
                                @if (auth()->user()->warnings()->active()->exists())
                                    <i class="{{ config('other.font-awesome') }} fa-exclamation-circle text-orange"
                                       title="{{ __('common.active-warning') }}"></i>
                                @endif
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.show', ['user' => auth()->user()]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-user"></i>
                            {{ __('user.my-profile') }}
                        </a>
                    </li>
                    <li>
                        <a class="top-nav--right__link" href="{{ route('users.general_settings.edit', ['user' => auth()->user()]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-cogs"></i>
                            {{ __('user.my-settings') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.privacy_settings.edit', ['user' => auth()->user()]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-eye"></i>
                            {{ __('user.my-privacy') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.achievements.index', ['user' => auth()->user()]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-trophy-alt"></i>
                            {{ __('user.my-achievements') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.torrents.index', ['user' => auth()->user()]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                            {{ __('user.my-uploads') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('requests.index', ['requestor' => auth()->user()->username]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-question"></i>
                            {{ __('user.my-requested') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('torrents.index', ['bookmarked' => 1]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-bookmark"></i>
                            {{ __('user.my-bookmarks') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.wishes.index', ['user' => auth()->user()]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-clipboard-list"></i>
                            {{ __('user.my-wishlist') }}
                        </a>
                    </li>
                    <li>
                        <form role="form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="top-nav--right__link" type="submit">
                                <i class='far fa-sign-out'></i>
                                {{ __('auth.logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <button
        class="top-nav__toggle {{ \config('other.font-awesome') }}"
        x-bind:class="expanded ? 'fa-times mobile' : 'fa-bars'"
        x-on:click="expanded = !expanded"
    ></button>
</nav>
