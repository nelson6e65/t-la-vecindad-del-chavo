<template>
  <div class="max-w-sm m-8">
    <div class="text-black text-5xl md:text-15xl font-black">
      404
    </div>

    <div class="w-16 h-1 bg-purple-light my-3 md:my-6" />

    <p class="text-grey-darker text-2xl md:text-3xl font-light mb-8 leading-normal">
      Sorry, the page you are looking for could not be found.
    </p>

    <a href="/">
      <button class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg">
        Go Home
      </button>
    </a>
  </div>
</template>

<script>
export default {
  layout: 'errors',
  name: 'NotFound'
}
</script>
