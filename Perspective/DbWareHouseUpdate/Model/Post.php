<?php
namespace Perspective\DbWareHouseUpdate\Model;

class Post extends \Perspective\DbWareHouse\Model\Post
{
    public function getProdsPrice()
    {
        $prodId = $this->getIdProd();
        $count = $this->getKolProd();
        $prod = $this->productRepository->getById($prodId);
        $prodPrice = $prod->getFinalPrice();
        
        return $prodPrice * $count;
    }
}
