<style>
    .content {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;

    }

    .content img{
        max-width: 640px;
        max-height: 407px;

    }
</style>
<div id="acceso_prohibido" class="content">
    <img src="assets/images/not-authorized.jpg">
</div>

<script>
    setTimeout(function(){ window.location.hash = "inicio"; }, 500);
</script>