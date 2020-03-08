<?php


namespace App\EventSubscriber\Entity;


use App\Entity\Article;
use App\Service\FileService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleEventSubscriber implements EventSubscriber
{
    /*
     * injecter un service dans un service non contrôleur
     *      créer une propriété
     *      créer un constructeur avec un paramètre réprésentant le service
     *      dans le constructeur, lier la propriété et le paramètre
     */
    private $slugger;
    private $fileService;


    public function __construct(SluggerInterface $slugger, FileService $fileService)
    {
        $this->slugger = $slugger;
        $this->fileService = $fileService;
    }

    public function prePersist(LifecycleEventArgs $event):void
    {
        // par défaut, les souscripteurs doctrine écoutent toutes les entités
        if($event->getObject() instanceof Article){
            $article = $event->getObject();
            $article->setSlug( $this->slugger->slug($article->getName())->lower() );

            if($article->getImage() instanceof UploadedFile){
                //appel d'un service
                $this->fileService->upload($article->getImage(), 'img/article');

                // Récupération du nom aléatoire du fichier generé dans le service
                $article->setImage($this->fileService->getFileName());
            }
        }
    }

    /*
     * getSubscribedEvents doit retourner un array des événements à écouter
     * principaux événements:
     *      - postLoad : après le chargement d'une entité
     *      - prePersist / postPersist : avant ou après la création d'une nouvelle entité dans la table (INSERT)
     *      - preUpdate / postUpdate : avant ou après la mise à jour d'une entité dans la table (UPDATE)
     *      - preRemove / postRemove : avant ou après la suppression d'une entité dans la table (DELETE)
     *
     * le nom des méthodes gérant les événements doivent reprendre strictement le nom de l'événement
     *
     * NE PAS OUBLIER de déclarer le souscripteur doctrine dans config/services.yaml
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::postLoad,
            Events::preUpdate,
            Events::preRemove,
            //Events::postUpdate
        ];
    }

    public function postLoad(LifecycleEventArgs $args):void
    {
        if($args->getObject() instanceof Article){
            // Propriété dynamique permettant de stocker le nom de l'image
            $article = $args->getObject();
            $article->prevImage = $article->getImage();
        }
    }

    public function preUpdate(LifecycleEventArgs $args):void
    {
        if($args->getObject() instanceof Article){
            $article = $args->getObject();

            if($article->getImage() instanceof UploadedFile){
                $this->fileService->upload($article->getImage(), 'img/article');
                $article->setImage($this->fileService->getFileName() );


                // Supprimer l'ancienne image à partir de la propriété dynamique créée dans
                // l'événement postLoad
                $this->fileService->delete($article->prevImage, 'img/article');
            }

            //Si aucune image n'a été sélectionnée
            else{
                // Recup de la propriété dynamique créée dans l'événement postLoad
                $article->setImage($article->prevImage);
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args):void
    {
        if($args->getObject() instanceof Article){
            $article = $args->getObject();
            // Supprimer l'ancienne image à partir de la propriété dynamique créée dans
            // l'événement postLoad
            $this->fileService->delete($article->prevImage, 'img/article');

        }
    }
}