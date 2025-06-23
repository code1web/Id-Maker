</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#single-data').click(function(){
            $('.student-form').show();
            $('.multiple-data').hide();
        });

        $('#multiple-data').click(function(){
            $('.student-form').hide();
            $('.multiple-data').show();
        });
    });
</script>