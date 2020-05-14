<!-- Microformats LD+JSON Module -->
{if $jsonVars['CW_LDJSON__BUSINESS_NAME'] != '' && $jsonVars['CW_LDJSON__BUSINESS_URL'] != ''}
 <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebSite",
  "name": "{$jsonVars['CW_LDJSON__BUSINESS_NAME']}",
  "alternateName": "{$shop_name}",
  "url": "{$jsonVars['CW_LDJSON__BUSINESS_URL']}"
}


 </script>
{/if}
{if $jsonVars['CW_LDJSON__BUSINESS_SHOW']}
 <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Organization",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "{$jsonVars['CW_LDJSON__BUSINESS_CITY']}",
            "addressRegion": "{$jsonVars['CW_LDJSON__BUSINESS_REGION']}",
            "postalCode": "{$jsonVars['CW_LDJSON__BUSINESS_POSTALCODE']}",
            "streetAddress": "{$jsonVars['CW_LDJSON__BUSINESS_ADDRESS']}"
          },
          "description": "{$jsonVars['CW_LDJSON__BUSINESS_DESCRIPTION']}",
          "name": "{$jsonVars['CW_LDJSON__BUSINESS_NAME']}",
          "telephone": "{$jsonVars['CW_LDJSON__BUSINESS_TELEPHONE']}",
          "url": "{$jsonVars['CW_LDJSON__BUSINESS_URL']}",
          "logo": "{$jsonVars['CW_LDJSON__BUSINESS_LOGO']}",
          "image": "{$jsonVars['CW_LDJSON__BUSINESS_LOGO']}",
          "priceRange": "{$jsonVars['CW_LDJSON__BUSINESS_PRICERANGE']}"
        }


 </script>
{/if}
{if $jsonVars['CW_LDJSON_PRODUCT_SHOW']}
 {if $phpself=="product"}
  <script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "Product",
        "url": "{$link->getProductLink($productVars)|escape:'htmlall':'UTF-8'}",
        "description": "{$meta_description|escape:'html':'UTF-8'}",
        "name": "{$productVars->name|escape:'html':'UTF-8'}",
        "image": "{$link->getImageLink($productVars->link_rewrite, $coverid.id_image, 'social_ads')}",
        "category": "{$jsonVars['cat_name']}",
        "offers": {
            "@type": "Offer",
            "availability": "http://schema.org/InStock",
            "itemCondition": "http://schema.org/NewCondition",
            "price": "{$productVars->getPrice(true, $smarty.const.NULL, 2)}",
            "priceCurrency": "{$jsonVars['currency_iso']}"
           }
        }


  </script>
 {/if}
{/if}
<!-- end Microformats LD+JSON Module -->