<template>
  <div>
    <h1 class="msg">{{message}}</h1>
  </div>
</template>

<script>

  export default {
    name: "app",
    data: function(){
      return {
        message: 'Hello from Vue!'
      }
    },
    mounted:function() { }
  }

</script>

<style scoped>
  h1.msg{
    color:green;
  }
</style>