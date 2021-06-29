document.addEventListener(`DOMContentLoaded`, () => {
  const galleries = document.querySelectorAll(`.gallery`)
  if (galleries) {
    galleries.forEach(gallery => {
      initGallery(gallery)
    })
  }
})

function initGallery(gallery) {
  const id = gallery.getAttribute(`id`)
  const lightbox = gallery.querySelector(`#lightbox-${id}`)
  const lightboxBackground = lightbox.querySelector(`.lightbox-background`)
  const galleryText = lightbox.querySelector(`#lightboxLabel-${id}`)
  const galleryImage = gallery.querySelector(`#lightboxImage-${id}`)
  const lightboxClose = lightbox.querySelector(`#lightboxClose-${id}`)
  const currentIndexLabel = lightbox.querySelector(
    `#lightboxIndex-${id} > .current-index`
  )
  const imageCountLabel = lightbox.querySelector(
    `#lightboxIndex-${id} > .image-count`
  )
  const galleryThumbs = gallery.querySelectorAll(`a.gallery-image`)

  imageCountLabel.innerHTML = galleryThumbs.length

  lightboxClose.addEventListener(`click`, e => {
    e.preventDefault()
    openLightbox(false)
  })
  lightboxBackground.addEventListener(`click`, e => {
    e.preventDefault()
    openLightbox(false)
  })

  const prevImage = lightbox.querySelector(`[data-gallery-prev]`)
  const nextImage = lightbox.querySelector(`[data-gallery-next]`)

  if (galleryThumbs) {
    galleryThumbs.forEach(thumb => {
      thumb.addEventListener(`click`, e => {
        // e.preventDefault()
        setModalImage(thumb)
      })
    })
  }

  prevImage.addEventListener(`click`, e => {
    e.preventDefault()
    setModalImage(
      gallery.querySelector(
        `a.gallery-image[data-image-index="${prevImage.dataset.galleryPrev}"]`
      )
    )
  })
  nextImage.addEventListener(`click`, e => {
    e.preventDefault()
    setModalImage(
      gallery.querySelector(
        `a.gallery-image[data-image-index="${nextImage.dataset.galleryNext}"]`
      )
    )
  })
  document.addEventListener(`keydown`, e => {
    if (lightbox.classList.contains(`is-open`)) {
      if (e.key === `ArrowRight`) {
        setModalImage(
          gallery.querySelector(
            `a.gallery-image[data-image-index="${nextImage.dataset.galleryNext}"]`
          )
        )
      } else if (e.key === `ArrowLeft`) {
        setModalImage(
          gallery.querySelector(
            `a.gallery-image[data-image-index="${prevImage.dataset.galleryPrev}"]`
          )
        )
      }
    }
  })
  document.addEventListener(`swiped-left`, e => {
    if (lightbox.classList.contains(`is-open`)) {
      setModalImage(
        gallery.querySelector(
          `a.gallery-image[data-image-index="${nextImage.dataset.galleryNext}"]`
        )
      )
    }
  })
  document.addEventListener(`swiped-right`, e => {
    if (lightbox.classList.contains(`is-open`)) {
      setModalImage(
        gallery.querySelector(
          `a.gallery-image[data-image-index="${prevImage.dataset.galleryPrev}"]`
        )
      )
    }
  })

  function setModalImage(image) {
    openLightbox()
    const imageIndex = image.getAttribute(`data-image-index`)
    currentIndexLabel.innerHTML = imageIndex
    if (imageIndex < galleryThumbs.length) {
      nextImage.setAttribute(`data-gallery-next`, Number(imageIndex) + 1)
    } else {
      nextImage.setAttribute(`data-gallery-next`, 1)
    }
    if (imageIndex > 1) {
      prevImage.setAttribute(`data-gallery-prev`, Number(imageIndex) - 1)
    } else {
      prevImage.setAttribute(`data-gallery-prev`, galleryThumbs.length)
    }
    const imageSrc = image.getAttribute(`data-image-src`)
    const imageTitle = image.getAttribute(`data-image-title`)
    galleryImage.setAttribute(`src`, imageSrc)
    galleryImage.setAttribute(`alt`, imageTitle)
    galleryText.innerHTML = imageTitle
  }

  function openLightbox(open = true) {
    if (open === true) {
      document.body.classList.add(`no-scroll`)
      lightbox.classList.add(`is-open`)
      lightbox.setAttribute(`aria-hidden`, false)
      lightbox.querySelectorAll(`[aria-hidden]`).forEach(el => {
        el.setAttribute(`aria-hidden`, false)
      })
    } else {
      document.body.classList.remove(`no-scroll`)
      lightbox.classList.remove(`is-open`)
      lightbox.setAttribute(`aria-hidden`, true)
      lightbox.querySelectorAll(`[aria-hidden]`).forEach(el => {
        el.setAttribute(`aria-hidden`, true)
      })
    }
  }
}
