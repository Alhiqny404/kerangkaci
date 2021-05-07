</div>
<!-- container // -->
</section>
<!-- ========================= FOOTER ========================= -->
<footer class="section-footer bg-secondary">
<div class="container">
<section class="footer-bottom border-top-white text-center">
<p class="text-white">
Made with &#10084; <br>
</p>
<p class="text-md-center text-white-50">
Copyright &copy <?= date('Y') ?> <br>
<a href="#" class="text-white-50">Anu Store</a>
</p>

</section>
<!-- //footer-top -->
</div>
<!-- //container -->
</footer>
<!-- ========================= FOOTER END // ========================= -->
<script>
$(document).ready(function() {
$.ajax({
url: "<?=site_url('home/count_cart') ?>",
type: 'get',
success: function(data) {
$('.count_cart').html(data);
}
})
});
</script>


</body>

</html>