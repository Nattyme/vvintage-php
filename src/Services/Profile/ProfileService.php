<?php 
declare(strict_types=1);

namespace Vvintage\Services\Profile;



class ProfileService
{
    private array $languages;
    private string $currentLang;
    private PostRepository $postRepository;
    private PostCategoryRepository $postCategoryRepository;

    public function __construct(array $languages, string $currentLang)
    {
      $this->languages = $languages;
      $this->currentLang = $currentLang;
    }


}
