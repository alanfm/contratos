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
        <script src="public/js/jquery.mask.min.js"></script>
        <script>
            $(document).on('click', '.delete', function(event) {
                event.preventDefault();
                result = confirm('Deseja realmente apagar o registro?');
                if (result) {
                    window.location.href = $(this).attr('href');
                }
            });
            $(document).on('click', '.cancel', function(event) {
                event.preventDefault();
                result = confirm('Deseja realmente cancelar?');
                if (result) {
                    window.location.href = $(this).attr('href');
                }
            });
            $(document).on('click', '.payment', function(){
                $('.payment-input').attr('value', $(this).data('parcela'));
                $('.description-input').attr('value', $(this).data('descricao'));
            });
            $(function(){
                $('.date').mask('00/00/0000');
                $('.cnpj').mask('00.000.000/0000-00');

                $('#estado').change(function(){
                    if($(this).val()) {
                        $.getJSON('enderecos/cidades/' + $(this).val(), function(data) {
                            console.log(data);
                            var options = []; 
                            $.each(data, function(k, v){
                                options.push('<option value="' + v.id + '">' + v.nome + '</option>');
                            });  
                            $('#cidade').html(options.join(''));
                        })
                        .fail(function() {
                            $('#quadra').html('<option value="">-- Este estado não tem cidades --</option>');
                        });
                    } else {
                        $('#cidade').html('<option value="">-- Escolha um estado --</option>');
                    }
                });

                $('#terreno').change(function(){
                    if($(this).val()) {
                        $.getJSON('terrenos/quadras/' + $(this).val(), function(data) {
                            var options = [];
                            options.push('<option value="">-- Escolha uma quadra --</option>');
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

                $(document).on('change', '#quadra', function(){
                    console.log($(this).val());
                    if($(this).val()) {
                        $.getJSON('terrenos/lotes/' + $(this).val(), function(data) {
                            var options = []; 
                            $.each(data, function(k, v){
                                options.push('<option value="' + v.id + '">' + v.descricao + '</option>');
                            });
                            $('#lote').html(options.join(''));
                        })
                        .fail(function() {
                            $('#lote').html('<option value="">-- Este quadra não tem lotes --</option>');
                        });
                    } else {
                        $('#lote').html('<option value="">-- Escolha uma quadra --</option>');
                    }
                });
            });
        </script>
    </body>
</html>