<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model;
use ImageStorage;

/////////////////////// FRONT: DEFAULT PRESENTER ///////////////////////

final class DefaultPresenter extends BasePresenter
{
	/** @var Model\ArticlesRepository */
	private $articleRepository;

	/** @var Model\GalleryRepository */
	private $galleryRepository;

	/** @var ImageStorage */
	private $imageStorage;

	public function __construct(
		Model\ArticlesRepository $articleRepository,
		Model\GalleryRepository $galleryRepository,
		ImageStorage $imageStorage
	)
	{
		$this->articleRepository = $articleRepository;
		$this->galleryRepository = $galleryRepository;
		$this->imageStorage = $imageStorage;
	}

	public function renderDefault()
	{
		$this->template->articles = $this->articleRepository->findAllWithTranslation();
		$this->template->galleries = $this->galleryRepository->findAll()->order('date DESC')->fetchAll();
	}

	public function renderDetail(int $id = null, string $htaccess = null)
	{
		if (!$id || !$htaccess) {
			$this->redirect('default');
		}
		$article = $this->articleRepository->findArticleTranslation('en', $id)->fetch();
		if (!$article) {
			$this->redirect('default');
		}
		$this->template->article = $article;
		$this->template->articleMedia = $this->articleRepository->findArticleImages($article->article_id)->fetchAll();
	}

	public function renderGallery(int $id = null, string $htaccess = null)
	{
		if (!$id || !$htaccess) {
			$this->redirect('default');
		}
		$gallery = $this->galleryRepository->findAll()->wherePrimary($id)->fetch();
		if (!$gallery) {
			$this->redirect('default');
		}
		$this->template->gallery = $gallery;
		$this->template->galleryMedia = $this->galleryRepository->findGalleryImages($gallery->id)->fetchAll();
	}
}
