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
            $(function(){
                $('#terreno').change(function(){
                    if($(this).val()) {
                        $.getJSON('terrenos/quadras/' + $(this).val(), function(data) {
                            var options = []; 
                            $.each(data, function(k, v){
                                options.push('<option value="' + v.id + '">' + v.descricao + '</option>');
                            });  
                            $('#quadra').html(options.join(''));
                        })
                        .fail(function() {
                            $('#quadra').html('<option value="">-- Este terreno não tem quadras --</option>');
                        });
                    } else {
                        $('#quadra').html('<option value="">-- Escolha um terreno --</option>');
                    }
                });
            });
        </script>
    </body>
</html>