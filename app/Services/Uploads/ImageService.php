<?php

declare(strict_types=1);

namespace App\Services\Uploads;

use App\Contracts\Uploads\ImageServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Override;
use Psr\Log\LoggerInterface;

readonly class ImageService implements ImageServiceContract
{
    public function __construct(
        private LoggerInterface $logger, private \Illuminate\Database\DatabaseManager $databaseManager,
    ) {}

    #[Override]
    public function replaceImages(Model $imageable, int $imageableId, string $path, Collection $images): Model
    {
        $op = __METHOD__;

        return $this->databaseManager->transaction(function () use ($op, $imageable, $images, $imageableId, $path) {
            $imageable->images()->forceDelete();

            $this->logger->info('images deleted', [
                'op' => $op,
                'imageable_id' => $imageableId,
                'images' => $images->toArray(),
            ]);

            $imageable->images()->createMany($images->map(function (string $image) use ($path) {
                $pathInfo = pathinfo($image);
                $fileName = $pathInfo['filename'];
                $extension = $pathInfo['extension'];

                return [
                    'path' => $path,
                    'name' => $fileName,
                    'extension' => $extension,
                ];
            }));

            $this->logger->info('images created', [
                'op' => $op,
                'imageable_id' => $imageableId,
                'images' => $images->toArray(),
            ]);

            return $imageable;
        });
    }

    #[Override]
    public function replaceImage(Model $imageable, int $imageableId, string $path, string $image): Model
    {
        $op = __METHOD__;

        return $this->databaseManager->transaction(function () use ($op, $imageable, $image, $imageableId, $path) {
            $imageable->image()->delete();

            $this->logger->info('image deleted', [
                'op' => $op,
                'imageable_id' => $imageableId,
                'image' => $image,
            ]);

            $pathInfo = pathinfo($image);
            $fileName = $pathInfo['filename'];
            $extension = $pathInfo['extension'];

            $imageable->image()->create([
                'path' => $path,
                'name' => $fileName,
                'extension' => $extension,
            ]);

            $this->logger->info('image created', [
                'op' => $op,
                'imageable_id' => $imageableId,
                'images' => $image,
            ]);

            return $imageable;
        });
    }
}
