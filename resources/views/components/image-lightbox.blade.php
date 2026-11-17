<style>
    .image-lightbox {
        max-width: 100vw;
        max-height: 100vh;
        padding: 3rem 1rem 1rem;
        border: 0;
        background: transparent;
        overflow: visible;
    }

    .image-lightbox::backdrop {
        background: rgb(0 0 0 / 88%);
    }

    .image-lightbox img {
        display: block;
        max-width: 96vw;
        max-height: 88vh;
        width: auto;
        height: auto;
        margin: auto;
        border-radius: 0.4rem;
        object-fit: contain;
    }

    .image-lightbox-close {
        position: fixed;
        top: 1rem;
        right: 1rem;
        width: 2.75rem;
        height: 2.75rem;
        border: 0;
        border-radius: 50%;
        color: #173a1d;
        background: white;
        font-size: 1.75rem;
        line-height: 1;
        cursor: pointer;
    }

    .image-zoom-trigger:focus-visible {
        outline: 3px solid #287b2d;
        outline-offset: 3px;
    }
</style>

<dialog id="image-lightbox" class="image-lightbox" aria-label="Vista ampliada de la imagen">
    <button class="image-lightbox-close" type="button" aria-label="Cerrar imagen ampliada">×</button>
    <img alt="">
</dialog>

<script>
    (() => {
        const dialog = document.getElementById('image-lightbox');
        const preview = dialog.querySelector('img');

        document.addEventListener('click', (event) => {
            if (!(event.target instanceof Element)) {
                return;
            }

            const trigger = event.target.closest('[data-image-zoom]');
            if (trigger) {
                preview.src = trigger.dataset.imageSrc;
                preview.alt = trigger.dataset.imageAlt || '';
                dialog.showModal();
            }
        });

        dialog.querySelector('.image-lightbox-close').addEventListener('click', () => dialog.close());
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) {
                dialog.close();
            }
        });
        dialog.addEventListener('close', () => {
            preview.removeAttribute('src');
            preview.alt = '';
        });
    })();
</script>
