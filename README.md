# m2-trusted-email

Add the followind config to one of your modules:

    <!-- app/code/YourNamespace/YourModule/etc/config.xml -->
    <?xml version="1.0"?>
    <config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
        xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/config.xsd">
        <default>
            <mtools>
                <trusted_email>
                    <domain_list>example.com,mydomain.com</domain_list>
                </trusted_email>
            </mtools>
        </default>
    </config>
