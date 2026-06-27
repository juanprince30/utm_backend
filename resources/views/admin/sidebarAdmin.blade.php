<!-- Vertical Sidebar -->
  <div>
    <div id="miniSidebar">
  <div class="brand-logo">
     <a class="d-flex align-items-center gap-2" href="">
      <h1 class="fw-bold fs-4  site-logo-text text-primary">ArtisanFaso</h1>
    </a>
  </div>
  <ul class="navbar-nav flex-column  ">


    <!-- Nav item -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.users') }}"><span class="text">Gestion Utilisateurs</span></a>
    </li>

    <!-- Nav item -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.commerces') }}">
         <span class="text">Gestion des Commerces</span></a>
    </li>


    <!-- Nav item -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.services') }}">
        <span class="text">Gestion des Services</span></a>
    </li>

    <!-- Nav item -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.commentaires') }}">
        <span class="text">Commentaires</span></a>
    </li>

  </ul>

</div>
