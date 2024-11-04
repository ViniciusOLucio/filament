<x-filament-panels::page>
    <iframe id="tjsp-iframe"
            src="https://esaj.tjsp.jus.br/cjsg/consultaCompleta.do?f=1"
            style="width: 100%; height: 80vh; border: none;">
    </iframe>

    <script>
        const iframe = document.getElementById('tjsp-iframe');

        iframe.onload = function () {
            const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

            iframeDocument.addEventListener('click', function (event) {
                const target = event.target.closest('a');
                if (target && target.href) {

                    // Ignora links com target="_blank"
                    if (target.getAttribute('target') !== '_blank') {
                        iframe.src = target.href; // Altera o src do iframe para o link clicado
                    } else {
                        // Se quiser também logar que um link com target="_blank" foi clicado
                        console.log('Link com target="_blank" foi clicado: ', target.href);
                    }
                }
            });
        };
    </script>
</x-filament-panels::page>
