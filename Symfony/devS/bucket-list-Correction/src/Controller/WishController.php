public function detail(int $id, WishRepository $wishRepository): Response
 {
 // récupère ce wish en fonction de l'id présent dans l'URL
 $wish = $wishRepository->find($id);
 }
 // s'il n'existe pas en bdd, on déclenche une erreur 404
 if (!$wish){
 throw $this->createNotFoundException('This wish do not exists! Sorry!');
 }
 return $this->render('wish/detail.html.twig', [
 "wish" => $wish
 ]);
 public function list(WishRepository $wishRepository): Response
 {
 // récupère les Wish publiés, du plus récent au plus ancien
 $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' =>
 'DESC']);
 }
 return $this->render('wish/list.html.twig', [
 // passe les données à Twig
 "wishes" => $wishes
 