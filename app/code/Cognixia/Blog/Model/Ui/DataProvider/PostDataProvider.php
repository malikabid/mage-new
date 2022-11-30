<?php

namespace Cognixia\Blog\Model\Ui\DataProvider;

use Cognixia\Blog\Model\ResourceModel\PostFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Cognixia\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\RequestInterface;

class PostDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $postFactory;
    protected $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        PostFactory $postFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->postFactory = $postFactory;
        $this->request = $request;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $post = $this->getCurrentPost();
        if (!$post->getData()) {
            return $post;
        }
        $this->loadedData[$post->getId()] = $post->getData();

        return $this->loadedData;
    }

    private function getCurrentPost()
    {
        $postId = $this->request->getParam('id');
        if ($postId) {
            try {
                $post = $this->collection->getFirstItem();
                $this->loadedData[$post->getId()] = $post->getData();
            } catch (LocalizedException $exception) {
                $post = $this->postFactory->create();
            }

            return $post;
        }

        $data = $this->dataPersistor->get('blog_post');
        if (empty($data)) {
            return $this->postFactory->create();
        }
        $this->dataPersistor->clear('blog_post');

        return $this->postFactory->create()
            ->setData($data);
    }
}
