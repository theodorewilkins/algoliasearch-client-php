<?php

namespace Algolia\AlgoliaSearch\Insights;

final class SearchInsightClient extends AbstractInsightsClient
{
    protected $queryId;

    public function setQueryId($queryId)
    {
        $this->queryId = $queryId;

        return $this;
    }

    public function clickedObjectID($eventName, $indexName, $objectIDs, $positions, $requestOptions = array())
    {
        $clickEvent = array(
            'objectsIDs' => is_array($objectIDs) ? $objectIDs : array($objectIDs),
            'positions' => is_array($positions) ? $positions : array($positions),
        );

        return $this->clicked($clickEvent, $eventName, $indexName, $requestOptions);
    }

    public function clickedFilters($eventName, $indexName, $filters, $requestOptions = array())
    {
        $clickEvent = array(
            'filters' => is_array($filters) ? $filters : array($filters),
        );

        return $this->clicked($clickEvent, $eventName, $indexName, $requestOptions);
    }

    private function clicked($clickEvent, $eventName, $indexName, $requestOptions = array())
    {
        $clickEvent = array_merge($clickEvent, array(
            'eventType' => 'click',
            'eventName' => $eventName,
            'index' => $indexName,
            'queryId' => $this->queryId,
        ));

        return $this->sendEvent($clickEvent, $requestOptions);
    }

    public function converted($eventName, $indexName, $objectIDs, $requestOptions = array())
    {
        $renameEvent = array(
            'eventType' => 'conversion',
            'eventName' => $eventName,
            'index' => $indexName,
            'objectsIDs' => is_array($objectIDs) ? $objectIDs : array($objectIDs),
        );

        return $this->sendEvent($renameEvent, $requestOptions);
    }

    public function sentEvent($event, $requestOptions = array())
    {
        $event['queryId'] = $this->queryId;

        return parent::sendEvent($event, $requestOptions);
    }
}
