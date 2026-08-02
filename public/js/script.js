document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-block-link').forEach(function (link) {
        var blockId = link.id.substring(7);
        var block = document.getElementById(blockId);

        if (!block) {
            return;
        }

        block.style.display = 'none';
        link.addEventListener('click', function (event) {
            event.preventDefault();
            block.style.display = block.style.display === 'none' ? '' : 'none';
        });
    });

    var ajaxLinks = document.querySelectorAll('.ajaxify');
    if (ajaxLinks.length === 0) {
        return;
    }

    var overlay = document.createElement('div');
    overlay.id = 'ajaxify-block';
    overlay.style.display = 'none';

    var close = document.createElement('a');
    close.href = '#';
    close.id = 'ajaxify-close';
    close.textContent = 'закрыть';

    var content = document.createElement('div');
    content.id = 'ajaxify-content';

    overlay.appendChild(close);
    overlay.appendChild(content);
    document.body.appendChild(overlay);

    close.addEventListener('click', function (event) {
        event.preventDefault();
        overlay.style.display = 'none';
    });

    ajaxLinks.forEach(function (link) {
        link.addEventListener('click', async function (event) {
            event.preventDefault();

            var informer = document.createElement('div');
            informer.id = 'ajaxify-informer';
            informer.style.top = window.scrollY + 'px';
            informer.textContent = 'loading...';
            document.body.appendChild(informer);

            try {
                var response = await fetch(link.href, {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Unable to load content');
                }

                content.innerHTML = await response.text();
                overlay.style.top = window.scrollY + 'px';
                overlay.style.display = 'block';
            } catch (error) {
                content.textContent = 'loading error';
                overlay.style.top = window.scrollY + 'px';
                overlay.style.display = 'block';
            } finally {
                informer.remove();
            }
        });
    });
});
