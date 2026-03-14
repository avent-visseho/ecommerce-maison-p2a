<?php

return [
    // ─── Authentification ────────────────────────────────────────────
    'auth' => [
        'email_already_registered' => 'Un compte existe déjà avec cette adresse email.',
        'sign_in_instead' => 'Se connecter avec cette adresse →',
        'config_error' => 'Une erreur de configuration interne est survenue. Veuillez contacter l\'administrateur.',
    ],

    // ─── Profil client ───────────────────────────────────────────────
    'profile' => [
        'updated' => 'Votre profil a été mis à jour avec succès.',
        'password_updated' => 'Votre mot de passe a été mis à jour avec succès.',
        'current_password_incorrect' => 'Le mot de passe actuel que vous avez saisi est incorrect. Veuillez réessayer.',
        'email_already_used' => 'Cette adresse email est déjà utilisée par un autre compte.',
    ],

    // ─── Panier ──────────────────────────────────────────────────────
    'cart' => [
        'product_added' => 'Le produit a été ajouté à votre panier.',
        'product_removed' => 'Le produit a été retiré de votre panier.',
        'updated' => 'La quantité dans votre panier a été mise à jour.',
        'cleared' => 'Votre panier a été vidé avec succès.',
        'empty' => 'Votre panier est actuellement vide.',
        'out_of_stock' => 'Ce produit est actuellement en rupture de stock.',
        'variant_out_of_stock' => 'Cette variante est actuellement en rupture de stock.',
        'insufficient_stock' => 'Stock insuffisant pour ce produit. Il n\'y a que :available en stock.',
        'variant_insufficient_stock' => 'Stock insuffisant pour cette variante. Il n\'y a que :available en stock.',
        'invalid_variant' => 'La variante sélectionnée n\'est pas valide pour ce produit.',
        'rental_added' => 'L\'objet de location a été ajouté à votre panier.',
        'rental_min_days' => 'La durée minimale de location pour cet objet est de :days jour(s).',
        'rental_max_days' => 'La durée maximale de location pour cet objet est de :days jour(s).',
        'rental_insufficient_stock' => 'Quantité demandée indisponible. Il n\'y a que :available exemplaire(s) disponible(s).',
        'rental_error' => 'Une erreur est survenue lors de l\'ajout de l\'objet au panier. Veuillez réessayer.',
    ],

    // ─── Validation de commande ──────────────────────────────────────
    'checkout' => [
        'cart_empty' => 'Votre panier est vide. Vous ne pouvez pas finaliser une commande sans produits.',
        'rental_not_found' => 'L\'objet de location ":name" n\'a pas été trouvé. Il a peut-être été supprimé du catalogue.',
        'rental_unavailable' => 'L\'objet ":name" n\'est plus disponible pour les dates sélectionnées. Veuillez choisir d\'autres dates.',
        'product_not_found' => 'Le produit ":name" n\'a pas été trouvé. Il a peut-être été supprimé du catalogue.',
        'insufficient_stock' => 'Stock insuffisant pour ":name". Veuillez réduire la quantité dans votre panier.',
        'error' => 'Une erreur inattendue est survenue lors du traitement de votre commande. Veuillez réessayer ou contacter notre équipe.',
    ],

    // ─── Contact ─────────────────────────────────────────────────────
    'contact' => [
        'sent' => 'Votre message a été envoyé avec succès. Notre équipe vous répondra dans les meilleurs délais.',
    ],

    // ─── Newsletter ──────────────────────────────────────────────────
    'newsletter' => [
        'subscribed' => 'Merci pour votre inscription ! Veuillez vérifier votre boîte de réception pour confirmer votre abonnement.',
        'already_subscribed' => 'Cette adresse email est déjà inscrite à notre newsletter. Vérifiez votre boîte de réception si vous n\'avez pas reçu l\'email de confirmation.',
        'verified' => 'Votre inscription à la newsletter a été confirmée avec succès !',
        'already_verified' => 'Votre email a déjà été vérifié. Vous êtes bien inscrit à notre newsletter.',
        'unsubscribed' => 'Vous avez été désinscrit de notre newsletter avec succès.',
    ],

    // ─── Commentaires ────────────────────────────────────────────────
    'comment' => [
        'submitted' => 'Votre commentaire a été bien reçu. Il sera affiché après modération par notre équipe.',
        'disabled' => 'Les commentaires sont désactivés pour cet article.',
        'invalid_parent' => 'Le commentaire parent n\'appartient pas à cet article.',
        'no_nested_reply' => 'Vous ne pouvez pas répondre directement à une réponse. Répondez au commentaire principal.',
    ],

    // ─── Paiement ────────────────────────────────────────────────────
    'payment' => [
        'already_paid' => 'Cette commande a déjà été payée.',
        'init_error' => 'Une erreur est survenue lors de l\'initiation du paiement. Veuillez vérifier vos informations et réessayer.',
    ],

    // ─── Location (public) ───────────────────────────────────────────
    'rental' => [
        'insufficient_quantity' => 'Désolé, seulement :available unité(s) disponible(s) pour ces dates.',
    ],

    // ─── Administration ──────────────────────────────────────────────
    'admin' => [
        'product' => [
            'created' => 'Produit créé avec succès.',
            'updated' => 'Produit mis à jour avec succès.',
            'deleted' => 'Produit supprimé avec succès.',
        ],
        'variant' => [
            'created' => 'Variante créée avec succès.',
            'created_many' => ':count variantes créées avec succès.',
            'updated' => 'Variante mise à jour avec succès.',
            'deleted' => 'Variante supprimée avec succès.',
        ],
        'category' => [
            'created' => 'Catégorie créée avec succès.',
            'updated' => 'Catégorie mise à jour avec succès.',
            'deleted' => 'Catégorie supprimée avec succès.',
        ],
        'brand' => [
            'created' => 'Marque créée avec succès.',
            'updated' => 'Marque mise à jour avec succès.',
            'deleted' => 'Marque supprimée avec succès.',
        ],
        'attribute' => [
            'created' => 'Attribut créé avec succès.',
            'updated' => 'Attribut mis à jour avec succès.',
            'deleted' => 'Attribut supprimé avec succès.',
        ],
        'attribute_value' => [
            'created' => 'Valeur ajoutée avec succès.',
            'updated' => 'Valeur mise à jour avec succès.',
            'deleted' => 'Valeur supprimée avec succès.',
        ],
        'order' => [
            'status_updated' => 'Statut de la commande mis à jour avec succès.',
            'payment_status_updated' => 'Statut de paiement mis à jour avec succès.',
        ],
        'blog_post' => [
            'created' => 'Article créé avec succès.',
            'updated' => 'Article mis à jour avec succès.',
            'deleted' => 'Article supprimé avec succès.',
        ],
        'blog_category' => [
            'created' => 'Catégorie de blog créée avec succès.',
            'updated' => 'Catégorie de blog mise à jour avec succès.',
            'deleted' => 'Catégorie de blog supprimée avec succès.',
        ],
        'blog_comment' => [
            'approved' => 'Commentaire approuvé avec succès.',
            'rejected' => 'Commentaire marqué comme spam.',
            'deleted' => 'Commentaire supprimé avec succès.',
        ],
        'rental_item' => [
            'created' => 'Objet de location créé avec succès.',
            'updated' => 'Objet de location mis à jour avec succès.',
            'deleted' => 'Objet de location supprimé avec succès.',
        ],
        'rental_category' => [
            'created' => 'Catégorie de location créée avec succès.',
            'updated' => 'Catégorie de location mise à jour avec succès.',
            'deleted' => 'Catégorie de location supprimée avec succès.',
        ],
        'rental_reservation' => [
            'status_updated' => 'Statut de la réservation mis à jour avec succès.',
        ],
    ],
];
