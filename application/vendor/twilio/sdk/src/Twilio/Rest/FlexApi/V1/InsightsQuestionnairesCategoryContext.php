<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Flex
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


namespace Twilio\Rest\FlexApi\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;


class InsightsQuestionnairesCategoryContext extends InstanceContext
    {
    /**
     * Initialize the InsightsQuestionnairesCategoryContext
     *
     * @param Version $version Version that contains the resource
     * @param string $categorySid The SID of the category to be deleted
     */
    public function __construct(
        Version $version,
        $categorySid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
        'categorySid' =>
            $categorySid,
        ];

        $this->uri = '/Insights/QualityManagement/Categories/' . \rawurlencode($categorySid)
        .'';
    }

    /**
     * Delete the InsightsQuestionnairesCategoryInstance
     *
     * @param array|Options $options Optional Arguments
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(array $options = []): bool
    {

        $options = new Values($options);

        $headers = Values::of(['Authorization' => $options['authorization']]);

        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }


    /**
     * Update the InsightsQuestionnairesCategoryInstance
     *
     * @param string $name The name of this category.
     * @param array|Options $options Optional Arguments
     * @return InsightsQuestionnairesCategoryInstance Updated InsightsQuestionnairesCategoryInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(string $name, array $options = []): InsightsQuestionnairesCategoryInstance
    {

        $options = new Values($options);

        $data = Values::of([
            'Name' =>
                $name,
        ]);

        $headers = Values::of(['Authorization' => $options['authorization']]);

        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);

        return new InsightsQuestionnairesCategoryInstance(
            $this->version,
            $payload,
            $this->solution['categorySid']
        );
    }


    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.FlexApi.V1.InsightsQuestionnairesCategoryContext ' . \implode(' ', $context) . ']';
    }
}