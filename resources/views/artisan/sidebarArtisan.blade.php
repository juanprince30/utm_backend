<!-- Sidebar Artisan -->
<div>
  <div id="miniSidebar">
    <div class="brand-logo">
      <a class="d-flex align-items-center gap-2" href="{{ route('artisan.dashboard') }}">
        <h1 class="fw-bold fs-4 site-logo-text text-primary">ArtisanFaso</h1>
      </a>
    </div>
    <ul class="navbar-nav flex-column">

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('artisan.dashboard') ? 'active' : '' }}"
           href="{{ route('artisan.dashboard') }}">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M5 12l-2 0l9 -9l9 9l-2 0"/>
              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/>
              <path d="M10 12h4v4h-4z"/>
            </svg>
          </span>
          <span class="text">Tableau de bord</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('artisan.commerces*') ? 'active' : '' }}"
           href="{{ route('artisan.commerces') }}">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M3 21l18 0"/>
              <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"/>
              <path d="M5 21l0 -10.15"/>
              <path d="M19 21l0 -10.15"/>
              <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"/>
            </svg>
          </span>
          <span class="text">Mes Commerces</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('artisan.services*') ? 'active' : '' }}"
           href="{{ route('artisan.services') }}">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M12 3l8 4v10l-8 4l-8 -4v-10z"/>
              <path d="M12 3v18"/>
              <path d="M4 7l8 4l8 -4"/>
            </svg>
          </span>
          <span class="text">Mes Services</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('artisan.commentaires') ? 'active' : '' }}"
           href="{{ route('artisan.commentaires') }}">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M8 9h8"/><path d="M8 13h6"/>
              <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"/>
            </svg>
          </span>
          <span class="text">Commentaires</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <a class="nav-link" href="{{ route('profile') }}">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                 stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
              <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
            </svg>
          </span>
          <span class="text">Mon Profil</span>
        </a>
      </li>

    </ul>
  </div>
</div>
