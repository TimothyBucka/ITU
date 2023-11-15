<template>
  <nav class="navbar navbar-expand-md bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand">NutriPlusCal</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Home</a>
              </li>

                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="route1">Recipes</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="route2">Calendar</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="#">My timetable</a>
                </li>
            </ul>
          </div>
        </div>
    </nav>
</template>

<script>
export default {
  props: ['route1', 'route2'],
}
</script>