Je veux un lien dans le header profil ce lien n'apparait que si l'utilisateur est connecté. Ce lien doit rediriger vers la page de profil de l'utilisateur connecté.

route => controller

Cette route est protéger il faut etre connecté pour y acceder
/profil
ProfileController

    / index
    affiche la liste des factures de l'utilisateur

    $id = $this->getUsers()->getId()
    order->findAllUserOrders()
    where order.user = user.id


    /detail/{id} show
    affiche le detail d'une facture
