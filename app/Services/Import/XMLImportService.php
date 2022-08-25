<?php

namespace App\Services\Import;

use App\Models\BodyType;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\EngineType;
use App\Models\GearType;
use App\Models\Generation;
use App\Models\Mark;
use App\Models\Offer;
use App\Models\Transmission;
use DOMDocument;
use DOMElement;
use RuntimeException;

class XMLImportService implements ImportServiceInterface
{

    private DOMDocument $xml;

    private const XSD_SCHEMA = 'app/Services/Import/schema/schema.xsd';
    private const TAG_OFFER = 'offer';
    private const TAG_MARK = 'mark';
    private const TAG_MODEL = 'model';
    private const TAG_GEN = 'generation';
    private const TAG_YEAR = 'year';
    private const TAG_RUN = 'run';
    private const TAG_COLOR = 'color';
    private const TAG_BODY = 'body-type';
    private const TAG_ENGINE = 'engine-type';
    private const TAG_TRANS = 'transmission';
    private const TAG_GEAR = 'gear-type';
    private const TAG_ID = 'id';
    private const TAG_GEN_ID = 'generation_id';
    private const OFFER_PROPERTIES = [
        self::TAG_MARK => Mark::class,
        self::TAG_MODEL => null,
        self::TAG_GEN => null,
        self::TAG_YEAR => null,
        self::TAG_RUN => null,
        self::TAG_COLOR => Color::class,
        self::TAG_BODY => BodyType::class,
        self::TAG_ENGINE => EngineType::class,
        self::TAG_TRANS => Transmission::class,
        self::TAG_GEAR => GearType::class,
        self::TAG_ID => null,
        self::TAG_GEN_ID => null,
    ];

    public function __construct()
    {
        $this->xml = new DOMDocument();
    }

    public function import(string $path): void
    {
        if (!file_exists($path)) {
            throw new RuntimeException('file not exists');
        }
        $this->xml->load($path);
        if (!$this->validateSchema()) {
            throw new RuntimeException('xml file has wrong schema');
        }
        $existOffersIds = Offer::getAllIds();
        $usedOfferIds = [];
        foreach ($this->xml->getElementsByTagName(self::TAG_OFFER) as $offer) {
            $usedOfferIds[] = $this->updateOrCreateOffer($offer);
        }
        $unusedOfferIds = array_diff($existOffersIds, $usedOfferIds);
        Offer::deleteUnusedOffers($unusedOfferIds);
    }

    private function validateSchema()
    {
        return $this->xml->schemaValidate(base_path() . '/' . self::XSD_SCHEMA);
    }

    private function updateOrCreateOffer(DOMElement $offer): int
    {
        $xmlPropertyValues = [];
        $propertyIds = [];
        foreach (self::OFFER_PROPERTIES as $tagName => $offerPropertyModel) {
            $xmlPropertyValues[$tagName] =
                mb_strtolower(trim($offer->getElementsByTagName($tagName)->item(0)->textContent));
            if (null !== $offerPropertyModel) {
                $propertyIds[$tagName] = '' === $xmlPropertyValues[$tagName] ?
                    null :
                    $offerPropertyModel::firstOrCreate(['name' => $xmlPropertyValues[$tagName]])->id;
            }
        }
        $propertyIds[self::TAG_MODEL] = null === $propertyIds[self::TAG_MARK] ?
            null :
            CarModel::firstOrCreate([
            'name' => $xmlPropertyValues[self::TAG_MODEL],
            'mark_id' => $propertyIds[self::TAG_MARK],
        ])->id;
        $emptyGeneration = '' === $xmlPropertyValues[self::TAG_GEN] || null === $propertyIds[self::TAG_MODEL];
        $propertyIds[self::TAG_GEN] = $emptyGeneration ?
            null :
            Generation::updateOrCreate(
                ['id' => $xmlPropertyValues[self::TAG_GEN_ID]],
                [
                    'name' => $xmlPropertyValues[self::TAG_GEN],
                    'car_model_id' => $propertyIds[self::TAG_MODEL]
                ]
            )->id;
        return Offer::updateOrCreate(
            ['id' => $xmlPropertyValues[self::TAG_ID]],
            [
                'mark_id' => $propertyIds[self::TAG_MARK],
                'car_model_id' => $propertyIds[self::TAG_MODEL],
                'generation_id' => $propertyIds[self::TAG_GEN],
                'year' => $xmlPropertyValues[self::TAG_YEAR],
                'run' => $xmlPropertyValues[self::TAG_RUN],
                'color_id' => $propertyIds[self::TAG_COLOR],
                'body_type_id' => $propertyIds[self::TAG_BODY],
                'engine_type_id' => $propertyIds[self::TAG_ENGINE],
                'transmission_id' => $propertyIds[self::TAG_TRANS],
                'gear_type_id' => $propertyIds[self::TAG_GEAR],
            ]
        )->id;
    }
}
