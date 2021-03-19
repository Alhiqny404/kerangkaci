<row></row>

<button type="button" class="btn btn-success toastrDefaultSuccess">
  Launch Success Toast
</button>
<script>
  $(document).ready(function() {
    toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
  });
  $('.toastrDefaultSuccess').click(function() {});
</script>