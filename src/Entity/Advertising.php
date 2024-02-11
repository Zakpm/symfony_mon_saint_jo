<?php

namespace App\Entity;

use App\Repository\AdvertisingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: AdvertisingRepository::class)]
#[Vich\Uploadable]
class Advertising
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(
        message: "Le titre est obligatoire."
    )]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le titre doit contenir au maximu {{ limit }} caractères.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

        
    #[Gedmo\Slug(fields: ['title'])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;


    #[Assert\Url(
        message: "L'URL {{ value }} n'est pas valide.",
    )]
    protected $bioUrl;
    #[ORM\Column(Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[Assert\Url(
        message: "L'URL {{ value }} n'est pas valide.",
    )]
    protected $bioUrl1;
    #[ORM\Column(length:255, nullable: true)]
    private ?string $content1 = null;

    #[Assert\Url(
        message: "L'URL {{ value }} n'est pas valide.",
    )]
    protected $bioUrl2;
    #[ORM\Column(length:255, nullable: true)]
    private ?string $content2 = null;

    // #[Assert\Url(
    //     message: "L'URL {{ value }} n'est pas valide.",
    // )]
    // protected $bioUrl5;
    // #[ORM\Column(length:255, nullable: true)]
    // private ?string $content3 = null;

    // #[Assert\Url(
    //     message: "L'URL {{ value }} n'est pas valide.",
    // )]
    // protected $bioUrl4;
    // #[ORM\Column(length:255, nullable: true)]
    // private ?string $content4 = null;



    #[Assert\File(
        maxSize: '2048k',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/bmp'],
        maxSizeMessage: "La taille de l'image doit être inférieur à 2 Mo.",
        mimeTypesMessage: 'Seuls les formats : jpeg, jpg, png, webp, bmp sont acceptés.',
    )]
    #[Vich\UploadableField(mapping: 'image_advertising', fileNameProperty: 'image')]
    private ?File $imageFile = null;


    #[Assert\File(
        maxSize: '2048k',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/bmp'],
        maxSizeMessage: "La taille de l'image doit être inférieur à 2 Mo.",
        mimeTypesMessage: 'Seuls les formats : jpeg, jpg, png, webp, bmp sont acceptés.',
    )]
    #[Vich\UploadableField(mapping: 'image_advertising', fileNameProperty: 'image1')]
    private ?File $imageFile1 = null;


    #[Assert\File(
        maxSize: '2048k',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/bmp'],
        maxSizeMessage: "La taille de l'image doit être inférieur à 2 Mo.",
        mimeTypesMessage: 'Seuls les formats : jpeg, jpg, png, webp, bmp sont acceptés.',
    )]
    #[Vich\UploadableField(mapping: 'image_advertising', fileNameProperty: 'image2')]
    private ?File $imageFile2 = null;


    #[Assert\File(
        maxSize: '2048k',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/bmp'],
        maxSizeMessage: "La taille de l'image doit être inférieur à 2 Mo.",
        mimeTypesMessage: 'Seuls les formats : jpeg, jpg, png, webp, bmp sont acceptés.',
    )]
    #[Vich\UploadableField(mapping: 'image_advertising', fileNameProperty: 'image3')]
    private ?File $imageFile3 = null;


    #[Assert\File(
        maxSize: '2048k',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/bmp'],
        maxSizeMessage: "La taille de l'image doit être inférieur à 2 Mo.",
        mimeTypesMessage: 'Seuls les formats : jpeg, jpg, png, webp, bmp sont acceptés.',
    )]
    #[Vich\UploadableField(mapping: 'image_advertising', fileNameProperty: 'image4')]
    private ?File $imageFile4 = null;


    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $image = null;


    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $image1 = null;


    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $image2 = null;


    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $image3 = null;


    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $image4 = null;

    

    #[ORM\Column(options: array("default" => false))]
    private ?bool $isPublished = null;
    


    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;


    
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

   


    public function __construct()
    {
        $this->isPublished = false;
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile1(?File $imageFile1 = null): void
    {
        $this->imageFile1 = $imageFile1;

        if (null !== $imageFile1) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile1(): ?File
    {
        return $this->imageFile1;
    }
     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile2(?File $imageFile2 = null): void
    {
        $this->imageFile2 = $imageFile2;

        if (null !== $imageFile2) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile2(): ?File
    {
        return $this->imageFile2;
    }

     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile3(?File $imageFile3 = null): void
    {
        $this->imageFile3 = $imageFile3;

        if (null !== $imageFile3) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile3(): ?File
    {
        return $this->imageFile3;
    }
     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile4(?File $imageFile4 = null): void
    {
        $this->imageFile4 = $imageFile4;

        if (null !== $imageFile4) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile4(): ?File
    {
        return $this->imageFile4;
    }





    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }
    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }
    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): self
    {
        $this->image3 = $image3;

        return $this;
    }
    public function getImage4(): ?string
    {
        return $this->image4;
    }

    public function setImage4(?string $image4): self
    {
        $this->image4 = $image4;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }



    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
    public function getContent1(): ?string
    {
        return $this->content1;
    }

    public function setContent1(?string $content1): self
    {
        $this->content1 = $content1;

        return $this;
    }

    public function getContent2(): ?string
    {
        return $this->content2;
    }

    public function setContent2(?string $content2): self
    {
        $this->content2 = $content2;

        return $this;
    }

    // public function getConten3t(): ?string
    // {
    //     return $this->content3;
    // }

    // public function setContent3(?string $content3): self
    // {
    //     $this->content3 = $content3;

    //     return $this;
    // }
    // public function getConten4(): ?string
    // {
    //     return $this->content4;
    // }

    // public function setContent4(?string $content4): self
    // {
    //     $this->content4 = $content4;

    //     return $this;
    // }





    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
