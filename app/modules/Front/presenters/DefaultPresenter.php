<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model;


/////////////////////// FRONT: DEFAULT PRESENTER ///////////////////////

final class DefaultPresenter extends BasePresenter
{
	/** @var Model\ArticlesRepository */
	private $articleRepository;

	public function __construct(
		Model\ArticlesRepository $articleRepository
	)
	{
		$this->articleRepository = $articleRepository;
	}

	public function renderDefault()
	{
		$this->template->articles = $this->articleRepository->findAllWithTranslation();
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
}
