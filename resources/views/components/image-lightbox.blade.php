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

    .image-lightbox-navigation {
        position: fixed;
        top: 50%;
        display: grid;
        min-width: 5.5rem;
        height: 2.75rem;
        place-items: center;
        padding: 0 0.9rem;
        border: 0;
        border-radius: 999px;
        color: #173a1d;
        background: white;
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        transform: translateY(-50%);
    }

    .image-lightbox-navigation[hidden] {
        display: none;
    }

    .image-lightbox-previous {
        left: 1rem;
    }

    .image-lightbox-next {
        right: 1rem;
    }

    @media (max-width: 480px) {
        .image-lightbox {
            padding-inline: 0.5rem;
        }

        .image-lightbox-navigation {
            top: auto;
            bottom: 1rem;
        }
    }

    .image-zoom-trigger:focus-visible {
        outline: 3px solid #287b2d;
        outline-offset: 3px;
    }
</style>

<dialog id="image-lightbox" class="image-lightbox" aria-label="Vista ampliada de la imagen">
    <button class="image-lightbox-close" type="button" aria-label="Cerrar imagen ampliada">×</button>
    <button class="image-lightbox-navigation image-lightbox-previous" type="button" aria-label="Imagen anterior" hidden>Anterior</button>
    <img alt="">
    <button class="image-lightbox-navigation image-lightbox-next" type="button" aria-label="Imagen siguiente" hidden>Siguiente</button>
</dialog>

<script>
    (() => {
        const dialog = document.getElementById('image-lightbox');
        const preview = dialog.querySelector('img');
        const previousButton = dialog.querySelector('.image-lightbox-previous');
        const nextButton = dialog.querySelector('.image-lightbox-next');
        let gallery = [];
        let currentIndex = 0;

        const showCurrentImage = () => {
            const trigger = gallery[currentIndex];
            preview.src = trigger.dataset.imageSrc;
            preview.alt = trigger.dataset.imageAlt || '';
        };

        const moveImage = (offset) => {
            currentIndex = (currentIndex + offset + gallery.length) % gallery.length;
            showCurrentImage();
        };

        document.addEventListener('click', (event) => {
            if (!(event.target instanceof Element)) {
                return;
            }

            const trigger = event.target.closest('[data-image-zoom]');
            if (trigger) {
                const galleryName = trigger.dataset.imageGallery;
                gallery = galleryName
                    ? Array.from(document.querySelectorAll('[data-lightbox-item][data-image-gallery]'))
                        .filter((item) => item.dataset.imageGallery === galleryName)
                    : [trigger];
                currentIndex = gallery.findIndex((item) => item.dataset.imageIndex === trigger.dataset.imageIndex);
                if (currentIndex < 0) {
                    currentIndex = gallery.indexOf(trigger);
                }
                previousButton.hidden = gallery.length < 2;
                nextButton.hidden = gallery.length < 2;
                showCurrentImage();
                dialog.showModal();
            }
        });

        previousButton.addEventListener('click', () => moveImage(-1));
        nextButton.addEventListener('click', () => moveImage(1));
        dialog.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                event.preventDefault();
                dialog.close();
            } else if (event.key === 'ArrowLeft' && gallery.length > 1) {
                moveImage(-1);
            } else if (event.key === 'ArrowRight' && gallery.length > 1) {
                moveImage(1);
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
            gallery = [];
            currentIndex = 0;
        });
    })();
</script>
