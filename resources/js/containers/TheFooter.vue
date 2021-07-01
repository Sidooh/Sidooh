<template>
  <CFooter :fixed="false">
      <div>
          <a href="#" target="_blank">Sidooh App</a>
          <span class="ml-1">&copy; {{ new Date().getFullYear() }}</span>
      </div>
      <div class="mfs-auto">
          <span class="mr-1">&copy;</span>
          <a href="#" target="_blank">Sidooh International</a>
      </div>
  </CFooter>
</template>

<script>
export default {
  name: 'TheFooter'
}
</script>
