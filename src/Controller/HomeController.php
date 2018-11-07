<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $em;
    private $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function index()
    {
        return $this->render("index.html.twig");
    }

    public function ficheProduit($id)
    {
        $product = $this->em->getRepository(Article::class)->find($id);

        return $this->render("Front/Pages/ficheProduit.html.twig", [
            "product" => $product,
        ]);
    }

    public function catalogue()
    {
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $products = $this->em->getRepository(Article::class)->findBy(array('categorie' => $_GET['category']));
        } else {
            $products = $this->em->getRepository(Article::class)->findAll();
        }

        return $this->render("Front/Pages/catalogue.html.twig", [
            "products" => $products,
        ]);
    }

    public function monPanier(Request $request)
    {
        //DELETE ARTICLE DU PANIER
        if (null !== ($tabIndex = $request->query->get('retirer'))) {
            $sessionProducts = $this->session->get('products');
            unset($sessionProducts[$tabIndex]);
            $sessionProducts = array_values($sessionProducts);
            $this->session->set('products', $sessionProducts);
        }

        $sessionProducts = false;
        if (!empty($this->session->get('products'))) {
            $sessionProducts = $this->session->get('products');
        }

        return $this->render("Front/Pages/monPanier.html.twig", [
            "products" => $sessionProducts,
        ]);
    }

    public function addToCart($productId)
    {
        $this->addFlash(
            'notice',
            'Votre produit a été ajouté au panier.'
        );
        $product = $this->em->getRepository(Article::class)->find($productId);
        //Get the products and push as an array
        $productArray = $this->session->get('products');
        $productArray[] = $product;

        $this->session->set('products', $productArray);

        return $this->redirectToRoute("catalogue");
    }

    public function mentionsLegales()
    {
        $text = "Le site est édité par :
                                 iComm
                                 12 rue de l'Isly
                                 75008 PARIS
                                 SARL au capital de : 110.000 €
                                 RCS Paris B 510 268 212

                                 Le directeur de la publication est la direction du Groupe ICOMM

                                 Le site est hébergé par : OVH

                                 ICOMM travaille en conformité avec les règles de déontologie applicables et les dispositions légales en matière de traitement des données personnelles des candidats afin de protéger ces données et de prévenir tout risque de discrimination. L’ensemble des candidatures, présentées sur le site, le sont de façon générique, le terme de candidat étant utilisé sans distinction de sexe.

                                 Les informations susceptibles d’être collectées sur le présent site sont exclusivement destinées au traitement de votre demande par le Groupe ICOMM, représenté par ICOMM & ICOMM RECRUTEMENT.

                                 Conformément aux dispositions des articles 38 et suivants de la loi 78-17 du 6 janvier 1978, vous disposez à tout moment d’un droit d’accès, de communication, de rectification, d’actualisation et de radiation des données personnelles vous concernant. Vous pouvez exercer l’un de ses droits en adressant un courrier à : ICOMM, 12 Rue de l’Isly, 75008 PARIS.

                                 Le traitement automatisé de données nominatives réalisé à partir de ce site web a fait l’objet d’une déclaration auprès de la Commission Nationale de l’Informatique et des Libertés (CNIL) qui en a délivré récépissé sous le numéro .

                                 Nous attirons votre attention sur le fait que les informations présentes sur son site WEB sont susceptibles de changement sans préavis, n’ont qu’une valeur indicative et ne constitue pas un conseil que seul est susceptible de vous donner un professionnel.

                                 Les dossiers candidats sont constitués dans le but d’aider les consultants du Groupe à sélectionner des profils et seront détruits à défaut d’action sur votre dossier, dans les 24 mois maximum après la dernière actualisation réalisée.

                                 Le présent site Web et l’ensemble de son contenu, y compris textes, images fixes ou animées, bases de données, programmes sont protégés par les droits d’auteur.

                                 Il ne vous est concédé qu’une autorisation de visualisation de son contenu à titre personnel et privé, à l’exclusion de toute visualisation ou diffusion publique. L’autorisation de reproduction ne vous est concédée que sous forme numérique sur votre ordinateur de consultation, aux fins de visualisation des pages ouvertes par votre logiciel de navigation. L’impression papier est autorisée aux fins de copie privée, à l’usage exclusif du copiste au sens de l’article L. 122-5 2° du Code de la Propriété Intellectuelle.

                                 La création d’un lien hypertexte sur le Site Web est autorisée sans frame vers l’adresse de la page d’accueil du site (www.anvergure.com) à l’exclusion de toute autre adresse.

                                 Toute autre utilisation non expressément visée aux présentes n’est pas permise et nécessite l’accord exprès écrit préalable d’ ICOMM. Vous n’êtes pas autorisés, notamment, en dehors des utilisations expressément concédées ci-dessus : de reproduire des marques et logos des Entités du Groupe ICOMM, de réaliser des liens hypertextes profonds sur tout élément du Site Web autre que la page d’accueil, d’utiliser ou d’extraire en tout ou en partie les bases de données utilisées par le Site Web, d’utiliser tous programmes ou cgi utilisés par le Site Web, etc.

                                 Le Groupe ICOMM ne vous garantit pas l’actualité ou la disponibilité de toute offre mentionnée dans le présent site Web, comme les termes définitifs, ni la durée d’une offre obtenue par le biais du présent site Web.

                                 De même, il ne vous garantit pas que le dépôt d’un dossier sur le site WEB en réponse à une annonce emporte la sollicitation d’un employeur ou d’un client, la proposition d’un entretien, ni une embauche, ni que les candidats seront disponibles ou correspondront aux besoins d’un employeur ou d’un client.

                                 Nous ne pouvons vous garantir la complétude, l’exactitude, l’adéquation ou l’actualité de l’information présente sur le présent site Web, comme le fonctionnement de ce dernier.

                                 Le présent Site Web a été créé en France. En l’utilisant, vous acceptez les conditions d’utilisation décrites ci avant, sans préjudice de tous recours de nature contractuelle ou délictuelle pouvant être exercés par ICOMM. Tout litige portant sur l’interprétation ou l’exécution d’un engagement contractuel prévu au présent site sera de la compétence exclusive des tribunaux français faisant application de la loi française.

                                 Droits de propriété Intellectuelle (c) 2014 ICOMM – tous droits réservés.

                                 Le présent site Web a été créé pour le compte du GROUPE ICOMM.

                                 Toute reproduction du présent site Web est interdite.";
        return $this->render("Front/Pages/mentionsLegales.html.twig", [
            'text' => $text,
        ]);
    }

    public function conditionsGenerales()
    {
        $text = "
        Conditions générales de vente iComm.com

        Siège social :
        
        Le Flavia 
        9 rue des bateaux-lavoirs 
        94768 Ivry-sur-Seine Cedex
        RCS Créteil B 377 853 536
        
        Les présentes conditions ne sont pas applicables aux produits vendus sur la MarketPlace
        
        1. Conditions générales de ventes des produits sur icomm.com
        
        Date de dernière mise à jour : 05/04/2017
        
        Il est préalablement précisé que les présentes conditions régissent exclusivement les ventes, par iComm Direct SA (Siège social : Le Flavia - 9 rue des bateaux-lavoirs - 94768 Ivry-sur-Seine Cedex RCS Créteil B 377 853 536) de produits éditoriaux (livres, livres épuisés, disques, vidéos, DVD, cédéroms etc.), de produits techniques (TV, informatique, téléphonie, photo, petit électroménager etc.) ainsi que les produits des rubriques jouets et maison. Ces conditions s'appliquent à l'exclusion de toutes autres conditions, notamment celles en vigueur pour les ventes en magasin.
        
        Article 1 - Prix
        
        1.1 - Les prix de nos produits sont indiqués en euros toutes taxes comprises (TVA + autres taxes et notamment taxe sur les vidéogrammes, éco-participation…) hors participation aux frais de traitement et d'expédition (voir Délais et coûts).
        
        1.2 - En cas de commande vers un pays autre que la France métropolitaine vous êtes l'importateur du ou des produits concernés. Pour tous les produits expédiés hors Union européenne et DOM-TOM, le prix sera calculé hors taxes automatiquement sur la facture. Des droits de douane ou autres taxes locales ou droits d'importation ou taxes d'état sont susceptibles d'être exigibles. Ces droits et sommes ne relèvent pas du ressort de iComm Direct. Ils seront à votre charge et relèvent de votre entière responsabilité, tant en termes de déclarations que de paiements aux autorités et/organismes compétents de votre pays. Nous vous conseillons de vous renseigner sur ces aspects auprès de vos autorités locales.
        
        1.3 - iComm Direct se réserve le droit de modifier ses prix à tout moment mais les produits seront facturés sur la base des tarifs en vigueur au moment de votre validation de commande.
        
        1.4 - Les produits demeurent la propriété de iComm Direct jusqu'au complet paiement du prix. Nous vous rappelons qu’au moment où vous prenez possession physiquement des produits commandés, les risques de perte ou d’endommagement des produits vont sont transférés.
        
        1.5 - FNAC Direct n'a pas vocation à vendre à des professionnels, les produits et services vendus par iComm Direct sont réservés aux particuliers.
        
        Article 2 - Commande
        
        Vous pouvez passer commande :
        
        Sur Internet : www.icomm.com.
        Par téléphone au 0 892 35 04 05 (Service 0,40€/min + prix appel) depuis la France métropolitaine. Du lundi au samedi de 9h à 19h30
        Au 33.1.53.56.28.00 depuis les DOM TOM et l'étranger Du lundi au samedi de 9h à 19h30.
        Les informations contractuelles sont présentées en langue française et feront l'objet d'une confirmation reprenant ces informations contractuelles au plus tard au moment de votre validation de commande.";

        return $this->render("Front/Pages/conditionsGenerales.html.twig",[
                'text' => $text,
            ]);
    }

    public function contact()
    {
        return $this->render("Front/Pages/contact.html.twig");
    }

    public function planSite()
    {
        return $this->render("Front/Pages/planSite.html.twig");
    }
}

?>