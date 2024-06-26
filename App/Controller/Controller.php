<?php

namespace App\Controller;

Class Controller 
{
    public function route():void
    {
        try {
            if (isset($_GET['controller'])) {
                switch ($_GET['controller']) {
                    case 'page':
                        # charger controleur page
                        $pageController = new PageController();
                        $pageController->route();
                        break;
                    case 'auth':
                        //charger controleur auth
                        $controller = new AuthController();
                        $controller->route();
                        break;
                    case 'user':
                        $controller = new UserController();
                        $controller->route();
                        break;
                    case 'medecin':
                        # charger controleur Medecin
                        $controller = new MedecinController();
                        $controller->route();
                        break;
                    case 'sejour':
                        # charger controleur Sejour
                        $controller = new SejourController();
                        $controller->route();
                        break;
                    case 'admin':
                        # charger controleur Admin
                        $controller = new AdminController();
                        $controller->route();
                        break;
                    default:
                        throw new \Exception("Le controleur n'existe pas");
                }
            } else {
                $pageController = new PageController();
                $pageController->home();
            }
            } catch (\Exception $e) {
                $this->render('errors/default', [
                    'error' => $e->getMessage()
                ]);
            }
        }
        

protected function render(string $path, array $params = []):void
{
    $filePath = _ROOTPATH_.'/templates/'.$path.'.php';

    try {
        if(!file_exists($filePath)) {
            throw new \Exception("Fichier non trouvé : ".$filePath);
        } else {
            extract($params);
            require_once $filePath;
        }
    } catch(\Exception $e) {
        $this->render('errors/default', [
            'error' => $e->getMessage()
        ]);
    }


    
    //require_once _ROOTPATH_. '/templates/page/about.php';
}

}