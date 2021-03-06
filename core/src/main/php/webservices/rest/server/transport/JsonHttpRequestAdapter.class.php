<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'webservices.rest.server.transport.AbstractHttpRequestAdapter',
    'webservices.json.JsonDecoder',
    'scriptlet.HttpScriptletException',
    'peer.http.HttpConstants'
  );
  
    
  /**
   * The JSON representation of HTTP request
   *
   * @test xp://net.xp_framework.unittest.rest.server.transport.JsonHttpRequestAdapterTest
   * @purpose Adapter
   */
  class JsonHttpRequestAdapter extends AbstractHttpRequestAdapter {
    
    /**
     * Retrieve body
     * 
     * @return var[]
     */
    public function getData() {
      if ('' === $this->request->getData()) return NULL;
      
      try {
        return create(new JsonDecoder())->decode($this->request->getData());
      } catch (JsonException $e) {
        throw new HttpScriptletException('Could not process JSON data.', HttpConstants::STATUS_BAD_REQUEST, $e);
      }
    }
  }
?>
