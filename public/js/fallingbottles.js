document.addEventListener('DOMContentLoaded', function () {
    var bottleWidth = 100;
    var bottles = Array.from(document.querySelectorAll('.filled-bottle'));
    var bottlesCount = bottles.length;
    var paused = true;
    var started = false;
    var resume = null;

    bottles.forEach(function (bottle, index) {
        bottle.style.left = ((index + 1) * bottleWidth) + 'px';
    });

    function getSongText(count, type) {
        if (type === 'lying') {
            return 'одна бутылка упала';
        }
        if (count > 4) {
            return count + ' бутылок стояло на столе';
        }
        if (count > 1) {
            return count + ' бутылки стояли на столе';
        }
        if (count === 1) {
            return count + ' бутылка стояла на столе';
        }
        return 'и нет больше бутылок на столе :(';
    }

    function showSongLine(type) {
        var songline = document.getElementById('songline');
        songline.textContent = getSongText(bottlesCount, type);
        songline.style.display = 'block';
    }

    function waitUntilPlaying() {
        if (!paused) {
            return Promise.resolve();
        }

        return new Promise(function (resolve) {
            resume = resolve;
        });
    }

    function animate(element, keyframes, duration) {
        return new Promise(function (resolve) {
            var animation = element.animate(keyframes, {
                duration: duration,
                easing: 'swing' in document.documentElement.style ? 'swing' : 'ease',
                fill: 'forwards'
            });
            animation.addEventListener('finish', resolve, { once: true });
        });
    }

    async function shiftLeft() {
        var standing = Array.from(document.querySelectorAll('.on-table'));
        await Promise.all(standing.map(async function (bottle) {
            var from = bottle.offsetLeft;
            var to = from - bottleWidth;
            await animate(bottle, [{ left: from + 'px' }, { left: to + 'px' }], 1000);
            bottle.style.left = to + 'px';
        }));
    }

    async function fall() {
        var bottle = document.querySelector('.on-table');
        if (!bottle) {
            return;
        }

        var from = bottle.offsetTop;
        await animate(bottle, [{ top: from + 'px' }, { top: '400px' }], 2000);
        bottle.style.top = '400px';
        bottle.classList.remove('on-table');
        bottle.innerHTML = '';
        bottle.classList.add('debris');
        bottlesCount = document.querySelectorAll('.on-table').length;
    }

    async function sing() {
        showSongLine();

        for (var index = 0; index < bottles.length; index += 1) {
            await waitUntilPlaying();
            showSongLine('staying');
            await waitUntilPlaying();
            await shiftLeft();
            await waitUntilPlaying();
            showSongLine('lying');
            await waitUntilPlaying();
            await fall();
        }

        await waitUntilPlaying();
        showSongLine('staying');
    }

    document.getElementById('sing-song').addEventListener('click', function (event) {
        event.preventDefault();
        paused = false;

        if (resume) {
            var continueSong = resume;
            resume = null;
            continueSong();
        }

        if (!started) {
            started = true;
            sing();
        }
    });

    document.getElementById('stop-song').addEventListener('click', function (event) {
        event.preventDefault();
        paused = true;
    });
});
