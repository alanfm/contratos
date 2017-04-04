        </main>
        <footer class="footer">
            <div class="container-fluid">
                <p class="text-muted">
                    Sistema de Gerencimento de Contratos e Prestações &copy; 2017<br>
                    <small>Power by <a href="#">Asterisco Soluções</a></small>
                </p>
            </div>
        </footer>
        <script src="public/js/jquery-3.1.1.min.js"></script>
        <script src="public/js/bootstrap.min.js"></script>
        <script>
            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                result = confirm('Deseja realmente apagar o registro?');
                if (result) {
                    window.location.href = $(this).attr('href');
                }
            });
            $(function(){
                $('#estado').change(function(){
                    if($(this).val()) {

                        $.getJSON('enderecos/cidades/' + $(this).val(), function(data) {
                            console.log(data);
                            var options = []; 
                            $.each(data, function(k, v){
                                options.push('<option value="' + v.id + '">' + v.nome + '</option>');
                            });  
                            $('#cidade').html(options.join(''));
                        });
                    } else {
                        $('#cidade').html('<option value="">-- Escolha um estado --</option>');
                    }
                });
            });
        </script>
    </body>
</html>