<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Manual LDAP</title>
        <!--<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1">-->
        <style type="text/css">
            <!--
            th {  background-color: #666666; font-weight: bold; color: #FFFFFF; font-size: 10px}
            body {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px}
            tr {  font-size: 10px}
            .core {  background-color: #FFFFB3}
            .cosine {  background-color: #CAFFFF}
            .inetOrgPerson {  background-color: #FFD2F8}
            td {  text-align: left; vertical-align: top}
            -->
        </style>
    </head>

    <body bgcolor="#FFFFFF" text="#000000">
        <h1>Esquemas más comunes de LDAP</h1>
        Estos esquemas se describen aquí, como se proporciona con la distribución <a href="http://www.openldap.org/">OpenLDAP</a>. Esta página es un intento de ofrecer una visión más útil de todos los atributos y clases disponibles para los desarrolladores de LDAP.
        <h2>Indice</h2>
        <ol>
            <li><a href="#leyenda">Leyenda</a></li>
            <li><a href="#atributos">Atributos</a></li>
            <li><a href="#clasesobjetos">Clases de objetos</a></li>
            <li><a href="#errorcodes">Códigos de error</a></li>
        </ol>
        <h2 id="leyenda">Leyenda</h2>
        <table border="1" cellspacing="0" cellpadding="0">
            <tr class="core"> 
                <td>Texto con fondo amarillo</td>
                <td>
                    <p>Tomado del esquema <tt>core.schema</tt>, RFC 2256</p>
    </td>
</tr>
<tr class="cosine"> 
    <td>Texo con fondo azul</td>
    <td>Tomado del esquema <tt>cosine.schema</tt>, RFC 1274</td>
</tr>
<tr class="inetOrgPerson"> 
    <td>Texto con fondo rosa</td>
    <td>Tomado del esquema <tt>inetOrgPerson.schema</tt>, RFC 2798</td>
</tr>
<tr>
    <td><i>Texto en itálica</i></td>
    <td>Adición/Modificación de la definición del RFC</td>
</tr>
<tr>
    <td> <s>Texto tachado</s></td>
    <td>Suprimido de la definición del RFC</td>
</tr>
</table>
<h2 id="atributos">Atributos</h2>
<table border="1" cellspacing="0" cellpadding="2">
    <tr> 
        <th>Atributo</th>
        <th>Superior/Tipo</th>
        <th>Descripción</th>
    </tr>
    <tr class="core"> 
        <td><a name="atObjectClass"></a>objectClass</td>
        <td>objectIdentifier</td>
        <td>The values of the objectClass attribute describe the kind of objectwhich 
            an entry represents. The objectClass attribute is present in every entry, 
            with at least two values. One of the values is either &quot;top&quot; or 
            &quot;alias&quot;.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atAliasedObjectName"></a>aliasedObjectName</td>
        <td>distinguishedName</td>
        <td>The aliasedObjectName attribute is used by the directory service if the 
            entry containing this attribute is an alias.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atKnowledgeInformation"></a>knowledgeInformation</td>
        <td>caseIgnore</td>
        <td>This attribute is no longer used.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atCn"></a>cn, commonName</td>
        <td>name</td>
        <td>This is the X.500 commonName attribute, which contains a name of an object. 
            If the object corresponds to a person, it is typically the person's full 
            name.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atSn"></a>sn, surname</td>
        <td>name</td>
        <td>This is the X.500 surname attribute, which contains the family name of 
            a person.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atSerialNumber"></a>serialNumber</td>
        <td>caseIgnore</td>
        <td>This attribute contains the serial number of a device.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atC"></a>c, countryName</td>
        <td>name</td>
        <td>This attribute contains a two-letter ISO 3166 country code.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atL"></a>l, localityName<br>
        </td>
        <td>name</td>
        <td>This attribute contains the name of a locality, such as a city, county 
            or other geographic region.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atSt"></a>st, stateOrProvinceName</td>
        <td>name</td>
        <td>This attribute contains the full name of a state or province.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atStreet"></a>street, streetAddress</td>
        <td>caseIgnore</td>
        <td>This attribute contains the physical address of the object to which the 
            entry corresponds, such as an address for package delivery.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atO"></a>o, organizationName</td>
        <td>name</td>
        <td>This attribute contains the name of an organization.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atOu"></a>ou, organizationalUnitName</td>
        <td>name</td>
        <td>This attribute contains the name of an organizational unit.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atTitle"></a>title<br>
        </td>
        <td>name</td>
        <td>This attribute contains the title, such as &quot;Vice President&quot;, 
            of a person in their organizational context. The &quot;personalTitle&quot; 
            attribute would be used for a person's title independent of their job function.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atDescription"></a>description</td>
        <td>caseIgnore</td>
        <td>This attribute contains a human-readable description of the object.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atSearchGuide"></a>searchGuide</td>
        <td>?</td>
        <td>This attribute is for use by X.500 clients in constructing search filters. 
            It is obsoleted by enhancedSearchGuide.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atBusinessCategory"></a>businessCategory</td>
        <td>caseIgnore</td>
        <td>This attribute describes the kind of business performed by an organization.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atPostalAddress"></a>postalAddress</td>
        <td>caseIgnoreList</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atPostalCode"></a>postalCode</td>
        <td>caseIgnore</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atPostOfficeBox"></a>postOfficeBox</td>
        <td>caseIgnore</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atPhysicalDeliveryOfficeName"></a>physicalDeliveryOfficeName</td>
        <td>caseIgnore</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atTelephoneNumber"></a>telephoneNumber</td>
        <td>telephoneNumber</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atTelexNumber"></a>telexNumber</td>
        <td>?</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atTeletexTerminalIdentifier"></a>teletexTerminalIdentifier</td>
        <td>?</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atFacsimileTelephoneNumber"></a>facsimileTelephoneNumber</td>
        <td>?</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atX121Address"></a>x121Address</td>
        <td>numericString</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atInternationaliSDNNumber"></a>internationaliSDNNumber</td>
        <td>numericString</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atRegisteredAddress"></a>registeredAddress</td>
        <td>postalAddress</td>
        <td>This attribute holds a postal address suitable for reception of telegrams 
            or expedited documents, where it is necessary to have the recipient accept 
            delivery.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atDestinationIndicator"></a>destinationIndicator</td>
        <td>caseIgnore</td>
        <td>This attribute is used for the telegram service.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atPreferredDeliveryMethod"></a>preferredDeliveryMethod</td>
        <td>?</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atPresentationAddress"></a>presentationAddress</td>
        <td>presentationAddress</td>
        <td>This attribute contains an OSI presentation address.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atSupportedApplicationContext"></a>supportedApplicationContext</td>
        <td>objectIdentifier</td>
        <td>This attribute contains the identifiers of OSI application contexts.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atMember"></a>member</td>
        <td>distinguishedName</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atOwner"></a>owner</td>
        <td>distinguishedName</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atRoleOccupant"></a>roleOccupant</td>
        <td>distinguishedName</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atSeeAlso"></a>seeAlso</td>
        <td>distinguishedName</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atUserPassword"></a>userPassword</td>
        <td>octetString</td>
        <td>Passwords are stored using an Octet String syntax and are not encrypted. 
            Transfer of cleartext passwords are strongly discouraged where the underlying 
            transport service cannot guarantee confidentiality and may result in disclosure 
            of the password to unauthorized parties.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atUserCertificate"></a>userCertificate</td>
        <td>?</td>
        <td>This attribute is to be stored and requested in the binary form, as 'userCertificate;binary'.<br>
        </td>
    </tr>
    <tr class="core"> 
        <td><a name="atCACertificate"></a>cACertificate</td>
        <td>?</td>
        <td>This attribute is to be stored and requested in the binary form, as 'cACertificate;binary'.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atAuthorityRevocationList"></a>authorityRevocationList</td>
        <td>?</td>
        <td>This attribute is to be stored and requested in the binary form, as 'authorityRevocationList;binary'.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atCertificateRevocationList"></a>certificateRevocationList</td>
        <td>?</td>
        <td>This attribute is to be stored and requested in the binary form, as 'certificateRevocationList;binary'.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atCrossCertificatePair"></a>crossCertificatePair</td>
        <td>?</td>
        <td>This attribute is to be stored and requested in the binary form, as 'crossCertificatePair;binary'.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atName"></a>name</td>
        <td>caseIgnoreMatch</td>
        <td>The name attribute type is the attribute supertype from which string attribute 
            types typically used for naming may be formed. It is unlikely that values 
            of this type itself will occur in an entry. LDAP server implementations 
            which do not support attribute subtyping need not recognize this attribute 
            in requests. Client implementations MUST NOT assume that LDAP servers are 
            capable of performing attribute subtyping.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atGivenName"></a>givenName</td>
        <td>name</td>
        <td>The givenName attribute is used to hold the part of a person's name which 
            is not their surname nor middle name.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atInitials"></a>initials</td>
        <td>name</td>
        <td>The initials attribute contains the initials of some or all of an individuals 
            names, but not the surname(s).</td>
    </tr>
    <tr class="core"> 
        <td><a name="atGenerationQualifier"></a>generationQualifier</td>
        <td>name</td>
        <td>The generationQualifier attribute contains the part of the name which 
            typically is the suffix, as in &quot;IIIrd&quot;.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atX500UniqueIdentifier"></a>x500UniqueIdentifier</td>
        <td>bitString</td>
        <td>The x500UniqueIdentifier attribute is used to distinguish between objects 
            when a distinguished name has been reused. This is a different attribute 
            type from both the &quot;uid&quot; and &quot;uniqueIdentifier&quot; types.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atDnQualifier"></a>dnQualifier</td>
        <td>caseIgnore</td>
        <td>The dnQualifier attribute type specifies disambiguating information to 
            add to the relative distinguished name of an entry. It is intended for use 
            when merging data from multiple sources in order to prevent conflicts between 
            entries which would otherwise have the same name. It is recommended that 
            the value of the dnQualifier attribute be the same for all entries from 
            a particular source.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atEnhancedSearchGuide"></a>enhancedSearchGuide</td>
        <td>?</td>
        <td>This attribute is for use by X.500 clients in constructing search filters.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atProtocolInformation"></a>protocolInformation</td>
        <td>protocolInformation</td>
        <td>This attribute is used in conjunction with the presentationAddress attribute, 
            to provide additional information to the OSI network service.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atDistinguishedName"></a>distinguishedName</td>
        <td>distinguishedName</td>
        <td>This attribute type is not used as the name of the object itself, but 
            it is instead a base type from which attributes with DN syntax inherit. 
            <p> It is unlikely that values of this type itself will occur in an entry. 
                LDAP server implementations which do not support attribute subtyping need 
                not recognize this attribute in requests. Client implementations MUST 
                NOT assume that LDAP servers are capable ofperforming attribute subtyping.</p>
        </td>
    </tr>
    <tr class="core"> 
        <td><a name="atUniqueMember"></a>uniqueMember</td>
        <td>uniqueMember</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="atHouseIdentifier"></a>houseIdentifier</td>
        <td>caseIgnore</td>
        <td>This attribute is used to identify a building within a location.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atSupportedAlgorithms"></a>supportedAlgorithms</td>
        <td>?</td>
        <td>This attribute is to be stored and requested in the binary form, as 'supportedAlgorithms;binary'.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atDeltaRevocationList"></a>deltaRevocationList</td>
        <td>?</td>
        <td>This attribute is to be stored and requested in the binary form, as 'deltaRevocationList;binary'.</td>
    </tr>
    <tr class="core"> 
        <td><a name="atDmdName"></a>dmdName</td>
        <td>?</td>
        <td>The value of this attribute specifies a directory management domain (DMD), 
            the administrative authority which operates the directory server.</td>
    </tr>
    <tr class="core"> 
        <td><i><a name="atDc"></a>dc</i>, domainComponent</td>
        <td>caseIgnoreIA5String</td>
        <td>The Domain Component attribute type specifies a DNS/NRS domain. For example, 
            &quot;uk&quot; or &quot;ac&quot;. RFC 1274 + RFC 2247</td>
    </tr>
    <tr class="core"> 
        <td><i><a name="atMail"></a>mail</i>, rfc822Mailbox</td>
        <td>caseIgnoreIA5String</td>
        <td>The RFC822 Mailbox attribute type specifies an electronic mailbox attribute 
            following the syntax specified in RFC 822. Note that this attribute should 
            not be used for greybook or other non-Internet order mailboxes. RFC 1274</td>
    </tr>
    <tr class="core"> 
        <td><i><a name="atUid"></a>uid</i>, userid</td>
        <td>caseIgnoreString</td>
        <td>The Userid attribute type specifies a computer system login name. RFC 
            1274</td>
    </tr>
    <tr class="core"> 
        <td><a name="atLabeledURI"></a>labeledURI</td>
        <td>caseExactIA5</td>
        <td>RFC2079: Uniform Resource Identifier with optional label</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atTextEncodedORAddress"></a>textEncodedORAddress</td>
        <td>caseIgnoreString</td>
        <td>The Text Encoded O/R Address attribute type specifies a text encoding 
            of an X.400 O/R address, as specified in RFC 987. The use of this attribute 
            is deprecated as the attribute is intended for interim use only. This attribute 
            will be the first candidate for the attribute expiry mechanisms!<br>
        </td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atInfo"></a>info</td>
        <td>caseIgnoreString</td>
        <td>The Information attribute type specifies any general information pertinent 
            to an object. It is recommended that specific usage of this attribute type 
            is avoided, and that specific requirements are met by other (possibly additional) 
            attribute types.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atFavouriteDrink"></a>favouriteDrink</td>
        <td>caseIgnoreString</td>
        <td>The Favourite Drink attribute type specifies the favourite drink of an 
            object (or person).</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atRoomNumber"></a>roomNumber</td>
        <td>caseIgnoreString</td>
        <td>The Room Number attribute type specifies the room number of an object. 
            Note that the commonName attribute should be used for naming room objects.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atPhoto"></a>photo</td>
        <td>g3-facsimile</td>
        <td>
            <p>The Photo attribute type specifies a &quot;photograph&quot; for an object. 
                This should be encoded in G3 fax as explained in recommendation T.4, with 
                an ASN.1 wrapper to make it compatible with an X.400 BodyPart as defined 
                in X.420.</p>
        </td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atUserClass"></a>userClass</td>
        <td>caseIgnoreString</td>
        <td>The User Class attribute type specifies a category of computer user. The 
            semantics placed on this attribute are for local interpretation. Examples 
            of current usage od this attribute in academia are undergraduate student, 
            researcher, lecturer, etc. Note that the organizationalStatus attribute 
            may now often be preferred as it makes no distinction between computer users 
            and others.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atHost"></a>host</td>
        <td>caseIgnoreString</td>
        <td>The Host attribute type specifies a host computer.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atManager"></a>manager</td>
        <td>distinguishedName</td>
        <td>The Manager attribute type specifies the manager of an object represented 
            by an entry.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atDocumentIdentifier"></a>documentIdentifier</td>
        <td>caseIgnoreString</td>
        <td>The Document Identifier attribute type specifies a unique identifier for 
            a document.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atDocumentTitle"></a>documentTitle</td>
        <td>caseIgnoreString</td>
        <td>The Document Title attribute type specifies the title of a document.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atDocumentVersion"></a>documentVersion</td>
        <td>caseIgnoreString</td>
        <td>The Document Version attribute type specifies the version number of a 
            document.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atDocumentAuthor"></a>documentAuthor</td>
        <td>distinguishedName</td>
        <td>The Document Author attribute type specifies the distinguished name of 
            the author of a document.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atDocumentLocation"></a>documentLocation</td>
        <td>caseIgnoreString</td>
        <td>The Document Location attribute type specifies the location of the document 
            original.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atHomeTelephoneNumber"></a>homeTelephoneNumber</td>
        <td>telephoneNumberSyntax</td>
        <td>The Home Telephone Number attribute type specifies a home telephone number 
            associated with a person. Attribute values should follow the agreed format 
            for international telephone numbers: i.e., &quot;+44 71 123 4567&quot;.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atSecretary"></a>secretary</td>
        <td>distinguishedName</td>
        <td>The Secretary attribute type specifies the secretary of a person. The attribute 
            value for Secretary is a distinguished name.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atOtherMailbox"></a>otherMailbox</td>
        <td>SEQUENCE {<br>
            mailboxType PrintableString, -- e.g. Telemail<br>
            mailbox IA5String -- e.g. X378:Joe<br>
            }<br>
        </td>
        <td>The Other Mailbox attribute type specifies values for electronic mailbox 
            types other than X.400 and rfc822</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atLastModifiedTime"></a>lastModifiedTime</td>
        <td>uTCTime</td>
        <td>The Last Modified Time attribute type specifies the last time, in UTC 
            time, that an entry was modified. Ideally, this attribute should be maintained 
            by the Directory System Agent (DSA).</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atLastModifiedBy"></a>lastModifiedBy</td>
        <td>distinguishedName</td>
        <td>The Last Modified By attribute specifies the distinguished name of the last 
            user to modify the associated entry. Ideally, this attribute should be maintained 
            by the Directory System Agent (DSA).</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atARecord"></a>aRecord</td>
        <td>DNSRecord</td>
        <td>The A Record attribute type specifies a type A (Address) DNS resource 
            record.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atMXRecord"></a>mXRecord</td>
        <td>DNSRecord</td>
        <td>The MX Record attribute type specifies a type MX (Mail Exchange) DNS resource 
            record.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atNSRecord"></a>nSRecord</td>
        <td>DNSRecord</td>
        <td>The NS Record attribute type specifies an NS (Name Server) DNS resource 
            record.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atSOARecord"></a>sOARecord</td>
        <td>DNSRecord</td>
        <td>The SOA Record attribute type specifies a type SOA (Start of Authority) 
            DNS resorce record.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atCNAMERecord"></a>cNAMERecord</td>
        <td>iA5String</td>
        <td>The CNAME Record attribute type specifies a type CNAME (Canonical Name) 
            DNS resource record.</td>
    </tr>
    <tr class="cosine"> 
        <td><s><a name="atAssociatedDomain"></a>associatedDomain</s></td>
        <td>caseIgnoreIA5String</td>
        <td>The Associated Domain attribute type specifies a DNS or NRS domain which 
            is associated with an object in the Directory Information Tree (DIT). For example, the entry in the Directory Information Tree (DIT) 
            with a distinguished name &quot;C=GB, O=University College London&quot; 
            would have an associated domain of &quot;UCL.AC.UK. Note that all domains 
            should be represented in rfc822 order.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atAssociatedName"></a>associatedName</td>
        <td>distinguishedName</td>
        <td>The Associated Name attribute type specifies an entry in the organisational 
            Directory Information Tree (DIT) associated with a DNS/NRS domain.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atHomePostalAddress"></a>homePostalAddress</td>
        <td>postalAddress</td>
        <td>The Home postal address attribute type specifies a home postal address 
            for an object. This should be limited to up to 6 lines of 30 characters 
            each.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atPersonalTitle"></a>personalTitle</td>
        <td>caseIgnoreString</td>
        <td>The Personal Title attribute type specifies a personal title for a person. 
            Examples of personal titles are &quot;Ms&quot;, &quot;Dr&quot;, &quot;Prof&quot; 
            and &quot;Rev&quot;.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atMobileTelephoneNumber"></a>mobileTelephoneNumber</td>
        <td>telephoneNumber</td>
        <td>The Mobile Telephone Number attribute type specifies a mobile telephone 
            number associated with a person. Attribute values should follow the agreed 
            format for international telephone numbers: i.e., &quot;+44 71 123 4567&quot;.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atPagerTelephoneNumber"></a>pagerTelephoneNumber</td>
        <td>telephoneNumber</td>
        <td>The Pager Telephone Number attribute type specifies a pager telephone 
            number for an object. Attribute values should follow the agreed format for 
            international telephone numbers: i.e., &quot;+44 71 123 4567&quot;.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atFriendlyCountryName"></a>friendlyCountryName</td>
        <td>caseIgnoreString</td>
        <td>The Friendly Country Name attribute type specifies names of countries 
            in human readable format. The standard attribute country name must be one 
            of the two-letter codes defined in ISO 3166.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atUniqueIdentifier"></a>uniqueIdentifier</td>
        <td>caseIgnoreString</td>
        <td>The Unique Identifier attribute type specifies a &quot;unique identifier&quot; 
            for an object represented in the Directory. The domain within which the 
            identifier is unique, and the exact semantics of the identifier, are for 
            local definition. For a person, this might be an institution-wide payroll 
            number. For an organisational unit, it might be a department code.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atOrganizationalStatus"></a>organizationalStatus</td>
        <td>caseIgnoreString</td>
        <td>The Organisational Status attribute type specifies a category by which 
            a person is often referred to in an organisation. Examples of usage in academia 
            might include undergraduate student, researcher, lecturer, etc.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atJanetMailbox"></a>janetMailbox</td>
        <td>caseIgnoreIA5String</td>
        <td>The Janet Mailbox attribute type specifies an electronic mailbox attribute 
            following the syntax specified in the Grey Book of the Coloured Book series. 
            This attribute is intended for the convenience of U.K users unfamiliar with 
            rfc822 and little-endian mail addresses. Entries using this attribute MUST 
            also include an rfc822Mailbox attribute.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atMailPreferenceOption"></a>mailPreferenceOption</td>
        <td>'no-list-inclusion', 'any-list-inclusion', 'professional-list-inclusion'</td>
        <td>An attribute to allow users to indicate a preference for inclusion of 
            their names on mailing lists (electronic or physical). The absence of such 
            an attribute should be interpreted as if the attribute was present with 
            value &quot;no-list-inclusion&quot;. This attribute should be interpreted 
            by anyone using the directory to derive mailing lists, and its value respected.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atBuildingName"></a>buildingName</td>
        <td>caseIgnoreString</td>
        <td>The Building Name attribute type specifies the name of the building where 
            an organisation or organisational unit is based.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atDSAQuality"></a>dSAQuality</td>
        <td>DSAQuality</td>
        <td>The DSA Quality attribute type specifies the purported quality of a Directory System Agent (DSA). 
            It allows a DSA manager to indicate the expected level of availability of 
            the DSA.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atSingleLevelQuality"></a>singleLevelQuality</td>
        <td>DataQuality</td>
        <td>The Single Level Quality attribute type specifies the purported data quality 
            at the level immediately below in the Directory Information Tree (DIT).</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atSubtreeMinimumQuality"></a>subtreeMinimumQuality</td>
        <td>DataQuality</td>
        <td>The Subtree Minimum Quality attribute type specifies the purported minimum 
            data quality for a Directory Information Tree (DIT) subtree.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atSubtreeMaximumQuality"></a>subtreeMaximumQuality</td>
        <td>DataQuality</td>
        <td>The Subtree Maximum Quality attribute type specifies the purported maximum 
            data quality for a Directory Information Tree (DIT) subtree.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atPersonalSignature"></a>personalSignature</td>
        <td>g3-facsimile</td>
        <td>The Personal Signature attribute type allows for a representation of a 
            person's signature. This should be encoded in G3 fax as explained in recommendation 
            T.4, with an ASN.1 wrapper to make it compatible with an X.400 BodyPart 
            as defined in X.420.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atdITRedirect"></a>dITRedirect</td>
        <td>distinguishedName</td>
        <td>The Directory Information Tree (DIT) Redirect attribute type is used to indicate that the object described 
            by one entry now has a newer entry in the Directory Information Tree (DIT). The entry containing the 
            redirection attribute should be expired after a suitable grace period. This 
            attribute may be used when an individual changes his/her place of work, 
            and thus acquires a new organisational DN.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atAudio"></a>audio</td>
        <td>audio</td>
        <td>The Audio attribute type allows the storing of sounds in the Directory. 
            The attribute uses a u-law encoded sound file as used by the &quot;play&quot; 
            utility on a Sun 4. This is an interim format.</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="atDocumentPublisher"></a>documentPublisher</td>
        <td>caseIgnoreString</td>
        <td>The Publisher of Document attribute is the person and/or organization 
            that published a document.</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atCarLicense"></a>carLicense</td>
        <td>caseIgnore</td>
        <td>This multivalued field is used to record the values of the license or 
            registration plate associated with an individual.</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atDepartmentNumber"></a>departmentNumber</td>
        <td>caseIgnore</td>
        <td>Code for department to which a person belongs. This can also be strictly 
            numeric (e.g., 1234) or alphanumeric (e.g., ABC/123).</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atDisplayName"></a>displayName</td>
        <td>caseIgnore</td>
        <td>When displaying an entry, especially within a one-line summary list, it 
            is useful to be able to identify a name to be used. Since other attribute 
            types such as 'cn' are multivalued, an additional attribute type is needed. Display name is defined for this purpose.</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atEmployeeNumber"></a>employeeNumber</td>
        <td>caseIgnore</td>
        <td>Numeric or alphanumeric identifier assigned to a person, typically based 
            on order of hire or association with an organization. Single valued.</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atEmployeeType"></a>employeeType</td>
        <td>caseIgnore</td>
        <td>Used to identify the employer to employee relationship. Typical values 
            used will be &quot;Contractor&quot;, &quot;Employee&quot;, &quot;Intern&quot;, 
            &quot;Temp&quot;, &quot;External&quot;, and &quot;Unknown&quot; but any 
            value may be used.</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atJpegPhoto"></a>jpegPhoto</td>
        <td>&nbsp;</td>
        <td>Used to store one or more images of a person using the JPEG File Interchange 
            Format [JFIF].</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atPreferredLanguage"></a>preferredLanguage</td>
        <td>caseIgnore</td>
        <td>Used to indicate an individual's preferred written or spoken language. 
            This is useful for international correspondence or human-computer interaction. 
            Values for this attribute type MUST conform to the definition of the Accept-Language header field defined in [RFC2068] 
            with one exception: the sequence &quot;Accept-Language&quot; &quot;:&quot; 
            should be omitted. This is a single valued attribute type.</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atUserSMIMECertificate"></a>userSMIMECertificate</td>
        <td>&nbsp;</td>
        <td>A PKCS#7 [RFC2315] SignedData, where the content that is signed is ignored 
            by consumers of userSMIMECertificate values. It is recommended that values 
            have a `contentType' of data with an absent `content' field. Values of this attribute contain a person's entire certificate 
            chain and an smimeCapabilities field [RFC2633] that at a minimum describes 
            their SMIME algorithm capabilities. Values for this attribute are to be 
            stored and requested in binary form, as 'userSMIMECertificate;binary'. If 
            available, this attribute is preferred over the userCertificate attribute 
            for S/MIME applications.</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td><a name="atUserPKCS12"></a>userPKCS12</td>
        <td>&nbsp;</td>
        <td>PKCS #12 provides a format for exchange of personal identity information. 
            When such information is stored in a directory service, the userPKCS12 attribute 
            should be used. This attribute is to be stored and requested in binary form, 
            as 'userPKCS12;binary'. The attribute values are PFX PDUs stored as binary 
            data.</td>
    </tr>
</table>
<h2 id="clasesobjetos">Clases de objetos</h2>
<table border="1" cellspacing="0" cellpadding="2">
    <tr> 
        <th>Clase de objeto</th>
        <th>Subclase de...</th>
        <th>Atributos obligatorios</th>
        <th>Atributos opcionales</th>
        <th>Descripción</th>
    </tr>
    <tr class="core"> 
        <td><a name="ocTop"></a>top</td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atObjectClass">objectClass</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>alias</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atAliasedObjectName">aliasedObjectName</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocCountry"></a>country</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atC">c</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atSearchGuide">searchGuide</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>locality</td>
        <td><a href="#ocTop">top</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atStreet">street</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atSearchGuide">searchGuide</a></li>
                <li><a href="#atSt">st</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocOrganization"></a>organization</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atO">o</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atUserPassword">userPassword</a></li>
                <li><a href="#atSearchGuide">searchGuide</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atX121Address">x121Address</a></li>
                <li><a href="#atRegisteredAddress">registeredAddress</a></li>
                <li><a href="#atDestinationIndicator">destinationIndicator</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atTelexNumber">telexNumber</a></li>
                <li><a href="#atTeletexTerminalIdentifier">teletexTerminalIdentifier</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atInternationaliSDNNumber">internationaliSDNNumber</a></li>
                <li><a href="#atFacsimileTelephoneNumber">facsimileTelephoneNumber</a></li>
                <li><a href="#atStreet">street</a></li>
                <li><a href="#atPostOfficeBox">postOfficeBox</a></li>
                <li><a href="#atPostalCode">postalCode</a></li>
                <li><a href="#atPostalAddress">postalAddress</a></li>
                <li><a href="#atPhysicalDeliveryOfficeName">physicalDeliveryOfficeName</a></li>
                <li><a href="#atSt">st</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocOrganizationalUnit"></a>organizationalUnit</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atOu">ou</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atUserPassword">userPassword</a></li>
                <li><a href="#atSearchGuide">searchGuide</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atX121Address">x121Address</a></li>
                <li><a href="#atRegisteredAddress">registeredAddress</a></li>
                <li><a href="#atDestinationIndicator">destinationIndicator</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atTelexNumber">telexNumber</a></li>
                <li><a href="#atTeletexTerminalIdentifier">teletexTerminalIdentifier</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atInternationaliSDNNumber">internationaliSDNNumber</a></li>
                <li><a href="#atFacsimileTelephoneNumber">facsimileTelephoneNumber</a></li>
                <li><a href="#atStreet">street</a></li>
                <li><a href="#atPostOfficeBox">postOfficeBox</a></li>
                <li><a href="#atPostalCode">postalCode</a></li>
                <li><a href="#atPostalAddress">postalAddress</a></li>
                <li><a href="#atPhysicalDeliveryOfficeName">physicalDeliveryOfficeName</a></li>
                <li><a href="#atSt">st</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocPerson"></a>person</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atSn">sn</a></li>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atUserPassword">userPassword</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocOrganizationalPerson"></a>organizationalPerson</td>
        <td><a href="#ocPerson">person</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atTitle">title</a></li>
                <li><a href="#atX121Address">x121Address</a></li>
                <li><a href="#atRegisteredAddress">registeredAddress</a></li>
                <li><a href="#atDestinationIndicator">destinationIndicator</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atTelexNumber">telexNumber</a></li>
                <li><a href="#atTeletexTerminalIdentifier">teletexTerminalIdentifier</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atInternationaliSDNNumber">internationaliSDNNumber</a></li>
                <li><a href="#atFacsimileTelephoneNumber">facsimileTelephoneNumber</a></li>
                <li><a href="#atStreet">street</a></li>
                <li><a href="#atPostOfficeBox">postOfficeBox</a></li>
                <li><a href="#atPostalCode">postalCode</a></li>
                <li><a href="#atPostalAddress">postalAddress</a></li>
                <li><a href="#atPhysicalDeliveryOfficeName">physicalDeliveryOfficeName</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atSt">st</a></li>
                <li><a href="#atL">l</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>organizationalRole</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atX121Address">x121Address</a></li>
                <li><a href="#atRegisteredAddress">registeredAddress</a></li>
                <li><a href="#atDestinationIndicator">destinationIndicator</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atTelexNumber">telexNumber</a></li>
                <li><a href="#atTeletexTerminalIdentifier">teletexTerminalIdentifier</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atInternationaliSDNNumber">internationaliSDNNumber</a></li>
                <li><a href="#atFacsimileTelephoneNumber">facsimileTelephoneNumber</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atRoleOccupant">roleOccupant</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atStreet">street</a></li>
                <li><a href="#atPostOfficeBox">postOfficeBox</a></li>
                <li><a href="#atPostalCode">postalCode</a></li>
                <li><a href="#atPostalAddress">postalAddress</a></li>
                <li><a href="#atPhysicalDeliveryOfficeName">physicalDeliveryOfficeName</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atSt">st</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>groupOfNames</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atMember">member</a></li>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atOwner">owner</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>residentialPerson</td>
        <td><a href="#ocPerson">person</a></td>
        <td> 
            <ul>
                <li><a href="#atL">l</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atX121Address">x121Address</a></li>
                <li><a href="#atRegisteredAddress">registeredAddress</a></li>
                <li><a href="#atDestinationIndicator">destinationIndicator</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atTelexNumber">telexNumber</a></li>
                <li><a href="#atTeletexTerminalIdentifier">teletexTerminalIdentifier</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atInternationaliSDNNumber">internationaliSDNNumber</a></li>
                <li><a href="#atFacsimileTelephoneNumber">facsimileTelephoneNumber</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atStreet">street</a></li>
                <li><a href="#atPostOfficeBox">postOfficeBox</a></li>
                <li><a href="#atPostalCode">postalCode</a></li>
                <li><a href="#atPostalAddress">postalAddress</a></li>
                <li><a href="#atPhysicalDeliveryOfficeName">physicalDeliveryOfficeName</a></li>
                <li><a href="#atSt">st</a></li>
                <li><a href="#atL">l</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>applicationProcess</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocApplicationEntity"></a>applicationEntity</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atPresentationAddress">presentationAddress</a></li>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atSupportedApplicationContext">supportedApplicationContext</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocDSA"></a>dSA</td>
        <td><a href="#ocApplicationEntity">applicationEntity</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atKnowledgeInformation">knowledgeInformation</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>device</td>
        <td><a href="#ocTop">top</a></td>
        <td>
            <ul>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atSerialNumber">serialNumber</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atOwner">owner</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>strongAuthenticationUser</td>
        <td><a href="#ocTop">top</a></td>
        <td>
            <ul>
                <li><a href="#atUserCertificate">userCertificate</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td><a name="ocCertificationAuthority"></a>certificationAuthority</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atAuthorityRevocationList">authorityRevocationList</a></li>
                <li><a href="#atCertificateRevocationList">certificateRevocationList</a></li>
                <li><a href="#atCACertificate">cACertificate</a> </li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atCrossCertificatePair">crossCertificatePair</a> </li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>groupOfUniqueNames</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atUniqueMember">uniqueMember</a></li>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atOwner">owner</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>userSecurityInformation</td>
        <td><a href="#ocTop">top</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atSupportedAlgorithms">supportedAlgorithms</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>certificationAuthority-V2</td>
        <td><a href="#ocCertificationAuthority">certificationAuthority</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atDeltaRevocationList">deltaRevocationList</a> </li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>cRLDistributionPoint</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atCn">cn</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atCertificateRevocationList">certificateRevocationList</a></li>
                <li><a href="#atAuthorityRevocationList">authorityRevocationList</a></li>
                <li><a href="#atDeltaRevocationList">deltaRevocationList</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>dmd</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atDmdName">dmdName</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atUserPassword">userPassword</a></li>
                <li><a href="#atSearchGuide">searchGuide</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atX121Address">x121Address</a></li>
                <li><a href="#atRegisteredAddress">registeredAddress</a></li>
                <li><a href="#atDestinationIndicator">destinationIndicator</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atTelexNumber">telexNumber</a></li>
                <li><a href="#atTeletexTerminalIdentifier">teletexTerminalIdentifier</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atInternationaliSDNNumber">internationaliSDNNumber</a></li>
                <li><a href="#atFacsimileTelephoneNumber">facsimileTelephoneNumber</a></li>
                <li><a href="#atStreet">street</a></li>
                <li><a href="#atPostOfficeBox">postOfficeBox</a></li>
                <li><a href="#atPostalCode">postalCode</a></li>
                <li><a href="#atPostalAddress">postalAddress</a></li>
                <li><a href="#atPhysicalDeliveryOfficeName">physicalDeliveryOfficeName</a></li>
                <li><a href="#atSt">st</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atDescription">description</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr class="core"> 
        <td>dcObject</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atDc">dc</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>RFC 2247</td>
    </tr>
    <tr class="core"> 
        <td>uidObject</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atUid">uid</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td> RFC 2377</td>
    </tr>
    <tr class="core"> 
        <td>labeledURIObject</td>
        <td><a href="#ocTop">top</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atLabeledURI">labeledURI</a></li>
            </ul>
        </td>
        <td>RFC2079: object that contains the URI attribute type</td>
    </tr>
    <tr class="cosine"> 
        <td>pilotObject</td>
        <td><a href="#ocTop">top</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atInfo">info</a></li>
                <li><a href="#atPhoto">photo</a></li>
                <li><a href="#atManager">manager</a></li>
                <li><a href="#atUniqueIdentifier">uniqueIdentifier</a></li>
                <li><a href="#atLastModifiedTime">lastModifiedTime</a></li>
                <li><a href="#atLastModifiedBy">lastModifiedBy</a></li>
                <li><a href="#atdITRedirect">dITRedirect</a></li>
                <li><a href="#atAudio">audio</a></li>
            </ul>
        </td>
        <td>The PilotObject object class is used as a sub-class to allow some common, 
            useful attributes to be assigned to entries of all other object classes.</td>
    </tr>
    <tr class="cosine"> 
        <td> 
            <p>pilotPerson, newPilotPerson</p>
        </td>
        <td><a href="#ocPerson">person</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atUserid">userid</a></li>
                <li><a href="#atTextEncodedORAddress">textEncodedORAddress</a></li>
                <li><a href="#atMail">mail</a></li>
                <li><a href="#atFavouriteDrink">favouriteDrink</a></li>
                <li> <a href="#atRoomNumber">roomNumber</a></li>
                <li><a href="#atUserClass">userClass</a></li>
                <li> <a href="#atHomeTelephoneNumber">homeTelephoneNumber</a></li>
                <li><a href="#atHomePostalAddress">homePostalAddress</a></li>
                <li><a href="#atSecretary">secretary</a></li>
                <li><a href="#atPersonalTitle">personalTitle</a></li>
                <li><a href="#atPreferredDeliveryMethod">preferredDeliveryMethod</a></li>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atJanetMailbox">janetMailbox</a></li>
                <li><a href="#atOtherMailbox">otherMailbox</a></li>
                <li><a href="#atMobileTelephoneNumber">mobileTelephoneNumber</a></li>
                <li><a href="#atPagerTelephoneNumber">pagerTelephoneNumber</a></li>
                <li><a href="#atOrganizationalStatus">organizationalStatus</a></li>
                <li><a href="#atMailPreferenceOption">mailPreferenceOption</a></li>
                <li><a href="#atPersonalSignature">personalSignature</a></li>
            </ul>
        </td>
        <td>The PilotPerson object class is used as a sub-class of person, to allow 
            the use of a number of additional attributes to be assigned to entries of 
            object class person.</td>
    </tr>
    <tr> 
        <td class="cosine">account</td>
        <td class="cosine"><a href="#ocTop">top</a></td>
        <td class="cosine"> 
            <ul>
                <li><a href="#atUid">userid</a></li>
            </ul>
        </td>
        <td class="cosine"> 
            <ul>
                <li><a href="#atDescription">description</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atHost">host</a></li>
            </ul>
        </td>
        <td class="cosine">The Account object class is used to define entries representing 
            computer accounts. The userid attribute should be used for naming entries 
            of this object class.</td>
    </tr>
    <tr class="cosine"> 
        <td>document</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atDocumentIdentifier">documentIdentifier</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atCommonName">commonName</a></li>
                <li><a href="#atDescription">description</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atOu">ou</a></li>
                <li><a href="#atDocumentTitle">documentTitle</a></li>
                <li><a href="#atDocumentVersion">documentVersion</a></li>
                <li><a href="#atDocumentAuthor">documentAuthor</a></li>
                <li><a href="#atDocumentLocation">documentLocation</a></li>
                <li><a href="#atDocumentPublisher">documentPublisher</a></li>
            </ul>
        </td>
        <td>The Document object class is used to define entries which represent documents.</td>
    </tr>
    <tr class="cosine"> 
        <td>room</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atCn">commonName</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atRoomNumber">roomNumber</a></li>
                <li><a href="#atDescription">description</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
            </ul>
        </td>
        <td>The Room object class is used to define entries representing rooms. The 
            commonName attribute should be used for naming pentries of this object class.</td>
    </tr>
    <tr class="cosine"> 
        <td>documentSeries</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atO">commonName</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atDescription">description</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><a href="#atL">l</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atOu">ou</a></li>
            </ul>
        </td>
        <td>The Document Series object class is used to define an entry which represents 
            a series of documents (e.g., The Request For Comments papers).</td>
    </tr>
    <tr class="cosine"> 
        <td><a name="ocDomain"></a>domain</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atDc">domainComponent</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><s>associatedName</s></li>
                <li><s>organizationName</s></li>
                <li><s>organizationalAttributeSet</s></li>
                <li><a href="#atUserPassword"><i>userPassword</i></a></li>
                <li><i><a href="#atSearchGuide">searchGuide</a></i></li>
                <li><a href="#atSeeAlso"><i>seeAlso</i></a></li>
                <li><a href="#atBusinessCategory"><i>businessCategory</i></a></li>
                <li><a href="#atX121Address"><i>x121Address</i></a></li>
                <li><a href="#atRegisteredAddress"><i>registeredAddress</i></a></li>
                <li><a href="#atDestinationIndicator"><i>destinationIndicator</i></a></li>
                <li><a href="#atPreferredDeliveryMethod"><i>preferredDeliveryMethod</i></a></li>
                <li><a href="#atTelexNumber"><i>telexNumber</i></a></li>
                <li><i><a href="#atTeletexTerminalIdentifier">teletexTerminalIdentifier</a></i></li>
                <li><i><a href="#atTelephoneNumber">telephoneNumber</a></i></li>
                <li><i><a href="#atInternationaliSDNNumber">internationaliSDNNumber</a></i></li>
                <li><i><a href="#atFacsimileTelephoneNumber">facsimileTelephoneNumber</a></i></li>
                <li><a href="#atStreet"><i>street</i></a></li>
                <li><a href="#atPostOfficeBox"><i>postOfficeBox</i></a></li>
                <li><i><a href="#atPostalCode">postalCode</a></i></li>
                <li><i><a href="#atPostalAddress">postalAddress</a></i></li>
                <li><i><a href="#atPhysicalDeliveryOfficeName">physicalDeliveryOfficeName</a></i></li>
                <li><i><a href="#atSt">st</a></i></li>
                <li><i><a href="#atL">l</a></i></li>
                <li><a href="#atDescription"><i>description</i></a></li>
            </ul>
        </td>
        <td>The Domain object class is used to define entries which represent DNS 
            or NRS domains. The domainComponent attribute should be used for naming 
            entries of this object class.</td>
    </tr>
    <tr class="cosine"> 
        <td>rFC822localPart</td>
        <td><a href="#ocDomain">domain</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atCn">cn</a></li>
                <li><a href="#atSn">sn</a></li>
                <li><a href="#atDescription">description</a></li>
                <li><a href="#atSeeAlso">seeAlso</a></li>
                <li><a href="#atTelephoneNumber">telephoneNumber</a></li>
                <li><s>postalAttributeSet</s></li>
                <li><s>telecommunicationAttributeSet</s></li>
            </ul>
        </td>
        <td>The RFC822 Local Part object class is used to define entries which represent 
            the local part of RFC822 mail addresses. This treats this part of an RFC822 
            address as a domain.</td>
    </tr>
    <tr class="cosine"> 
        <td>dNSDomain</td>
        <td><a href="#ocDomain">domain</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atARecord">ARecord</a></li>
                <li><a href="#atMDRecord">MDRecord</a></li>
                <li><a href="#atMXRecord">MXRecord</a></li>
                <li><a href="#atNSRecord">NSRecord</a></li>
                <li><a href="#atSOARecord">SOARecord</a></li>
                <li><a href="#atCNAMERecord">CNAMERecord</a></li>
            </ul>
        </td>
        <td>The DNS Domain (Domain NameServer) object class is used to define entries 
            for DNS domains.</td>
    </tr>
    <tr class="cosine"> 
        <td>domainRelatedObject</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atAssociatedDomain">associatedDomain</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>The Domain Related Object object class is used to define entries which 
            represent DNS/NRS domains which are &quot;equivalent&quot; to an X.500 domain: 
            e.g., an organisation or organisational unit.</td>
    </tr>
    <tr class="cosine"> 
        <td>friendlyCountry</td>
        <td><a href="#ocCountry">country</a></td>
        <td> 
            <ul>
                <li><a href="#atFriendlyCountryName">friendlyCountryName</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>The Friendly Country object class is used to define country entries in 
            the Directory Information Tree (DIT). The object class is used to allow friendlier naming of countries 
            than that allowed by the object class country. The naming attribute of object 
            class country, countryName, has to be a 2 letter string defined in ISO 3166.</td>
    </tr>
    <tr class="cosine"> 
        <td><i>simpleSecurityObject</i></td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atUserPassword">userPassword</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>The Simple Security Object object class is used to allow an entry to have 
            a userPassword attribute when an entry's principal object classes do not 
            allow userPassword as an attribute type.</td>
    </tr>
    <tr class="cosine"> 
        <td>pilotOrganization</td>
        <td><a href="#ocOrganization">organization</a>, <a href="#ocOrganizationalUnit">organizationalUnit</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atBuildingName">buildingName</a></li>
            </ul>
        </td>
        <td>The PilotOrganization object class is used as a sub-class of organization 
            and organizationalUnit to allow a number of additional attributes to be 
            assigned to entries of object classes organization and organizationalUnit.</td>
    </tr>
    <tr class="cosine"> 
        <td>pilotDSA</td>
        <td><a href="#ocDSA">dsa</a></td>
        <td> 
            <ul>
                <li><a href="#atDSAQuality">dSAQuality</a></li>
            </ul>
        </td>
        <td>&nbsp;</td>
        <td>The PilotDSA object class is used as a sub-class of the dsa object class 
            to allow additional attributes to be assigned to entries for Directory System Agents (DSAs).</td>
    </tr>
    <tr class="cosine"> 
        <td>qualityLabelledData</td>
        <td><a href="#ocTop">top</a></td>
        <td> 
            <ul>
                <li><a href="#atDSAQuality">dSAQuality</a></li>
            </ul>
        </td>
        <td> 
            <ul>
                <li><a href="#atSubtreeMinimumQuality">subtreeMinimumQuality</a></li>
                <li><a href="#atSubtreeMaximumQuality">subtreeMaximumQuality</a></li>
            </ul>
        </td>
        <td>The Quality Labelled Data object class is used to allow the assignment 
            of the data quality attributes to subtrees in the Directory Information Tree (DIT).</td>
    </tr>
    <tr class="inetOrgPerson"> 
        <td>inetOrgPerson</td>
        <td><a href="#ocOrganizationalPerson">organizationalPerson</a></td>
        <td>&nbsp;</td>
        <td> 
            <ul>
                <li><a href="#atAudio">audio</a></li>
                <li><a href="#atBusinessCategory">businessCategory</a></li>
                <li><a href="#atCarLicense">carLicense</a></li>
                <li><a href="#atDepartmentNumber">departmentNumber</a></li>
                <li><a href="#atDisplayName">displayName</a></li>
                <li><a href="#atEmployeeNumber">employeeNumber</a></li>
                <li><a href="#atEmployeeType">employeeType</a></li>
                <li><a href="#atGivenName">givenName</a></li>
                <li><a href="#atHomePhone">homePhone</a></li>
                <li><a href="#atHomePostalAddress">homePostalAddress</a></li>
                <li><a href="#atInitials">initials</a></li>
                <li><a href="#atJpegPhoto">jpegPhoto</a></li>
                <li><a href="#atLabeledURI">labeledURI</a></li>
                <li><a href="#atMail">mail</a></li>
                <li><a href="#atManager">manager</a></li>
                <li><a href="#atMobile">mobile</a></li>
                <li><a href="#atO">o</a></li>
                <li><a href="#atPager">pager</a></li>
                <li><a href="#atPhoto">photo</a></li>
                <li><a href="#atRoomNumber">roomNumber</a></li>
                <li><a href="#atSecretary">secretary</a></li>
                <li><a href="#atUid">uid</a></li>
                <li><a href="#atUserCertificate">userCertificate</a></li>
                <li><a href="#atX500uniqueIdentifier">x500uniqueIdentifier</a></li>
                <li><a href="#atPreferredLanguage">preferredLanguage</a></li>
                <li><a href="#atUserSMIMECertificate">userSMIMECertificate</a></li>
                <li><a href="#atUserPKCS12">userPKCS12</a></li>
            </ul>
        </td>
        <td>The inetOrgPerson represents people who are associated with an organization 
            in some way. It is a structural class and is derived from the organizationalPerson 
            class which is defined in X.521.</td>
    </tr>
</table>
<h2 id="errorcodes">Códigos de error</h2>
<table border="1" cellspacing="0" cellpadding="2">
    <tr> 
        <th>Error / Código de error</th>
        <th>Texto</th>
        <th>Descripción</th>
    </tr>
    <tr>
        <td>0</td>
        <td>LDAP_SUCCESS</td>
        <td>Indicates the requested client operation completed successfully.</td>
    </tr>
    <tr>
        <td>2</td>
        <td>LDAP_PROTOCOL_ERROR</td>
        <td>Indicates that the server has received an invalid or malformed request from
            the client.</td>
    </tr>
    <tr>
        <td>3</td>
        <td>LDAP_TIMELIMIT_EXCEEDED</td>
        <td>Indicates that the operation&#39;s time limit specified by either the client or
            the server has been exceeded. On search operations, incomplete results are
            returned.</td>
    </tr>
    <tr>
        <td>4</td>
        <td>LDAP_SIZELIMIT_EXCEEDED</td>
        <td>Indicates that in a search operation, the size limit specified by the client
            or the server has been exceeded. Incomplete results are returned.</td>
    </tr>
    <tr>
        <td>5</td>
        <td>LDAP_COMPARE_FALSE</td>
        <td>Does not indicate an error condition. Indicates that the results of a compare
            operation are false.</td>
    </tr>
    <tr>
        <td>6</td>
        <td>LDAP_COMPARE_TRUE</td>
        <td>Does not indicate an error condition. Indicates that the results of a compare
            operation are true.</td>
    </tr>
    <tr>
        <td>7</td>
        <td>LDAP_AUTH_METHOD_NOT_SUPPORTED</td>
        <td>Indicates that during a bind operation the client requested an authentication
            method not supported by the LDAP server.</td>
    </tr>
    <tr>
        <td>8</td>
        <td>LDAP_STRONG_AUTH_REQUIRED</td>
        <td>Indicates one of the following: In bind requests, the LDAP server accepts
            only strong authentication. In a client request, the client requested an operation
            such as delete that requires strong authentication. In an unsolicited notice of
            disconnection, the LDAP server discovers the security protecting the communication
            between the client and server has unexpectedly failed or been compromised.</td>
    </tr>
    <tr>
        <td>9</td>
        <td></td>
        <td>Reserved.</td>
    </tr>
    <tr>
        <td>10</td>
        <td>LDAP_REFERRAL</td>
        <td>Does not indicate an error condition. In LDAPv3, indicates that the server
            does not hold the target entry of the request, but that the servers in the
            referral field may.</td>
    </tr>
    <tr>
        <td>11</td>
        <td>LDAP_ADMINLIMIT_EXCEEDED</td>
        <td>Indicates that an LDAP server limit set by an administrative authority has
            been exceeded.</td>
    </tr>
    <tr>
        <td>12</td>
        <td>LDAP_UNAVAILABLE_CRITICAL_EXTENSION</td>
        <td>Indicates that the LDAP server was unable to satisfy a request because one or
            more critical extensions were not available. Either the server does not support
            the control or the control is not appropriate for the operation type.</td>
    </tr>
    <tr>
        <td>13</td>
        <td>LDAP_CONFIDENTIALITY_REQUIRED</td>
        <td>Indicates that the session is not protected by a protocol such as Transport
            Layer Security (TLS), which provides session confidentiality.</td>
    </tr>
    <tr>
        <td>14</td>
        <td>LDAP_SASL_BIND_IN_PROGRESS</td>
        <td>Does not indicate an error condition, but indicates that the server is ready
            for the next step in the process. The client must send the server the same SASL
            mechanism to continue the process.</td>
    </tr>
    <tr>
        <td>15</td>
        <td></td>
        <td>Not used.</td>
    </tr>
    <tr>
        <td>16</td>
        <td>LDAP_NO_SUCH_ATTRIBUTE</td>
        <td>Indicates that the attribute specified in the modify or compare operation
            does not exist in the entry.</td>
    </tr>
    <tr>
        <td>17</td>
        <td>LDAP_UNDEFINED_TYPE</td>
        <td>Indicates that the attribute specified in the modify or add operation does
            not exist in the LDAP server&#39;s schema.</td>
    </tr>
    <tr>
        <td>18</td>
        <td>LDAP_INAPPROPRIATE_MATCHING</td>
        <td>Indicates that the matching rule specified in the search filter does not
            match a rule defined for the attribute&#39;s syntax.</td>
    </tr>
    <tr>
        <td>19</td>
        <td>LDAP_CONSTRAINT_VIOLATION</td>
        <td>Indicates that the attribute value specified in a modify, add, or modify DN
            operation violates constraints placed on the attribute. The constraint can be one
            of size or content (string only, no binary).</td>
    </tr>
    <tr>
        <td>20</td>
        <td>LDAP_TYPE_OR_VALUE_EXISTS</td>
        <td>Indicates that the attribute value specified in a modify or add operation
            already exists as a value for that attribute.</td>
    </tr>
    <tr>
        <td>21</td>
        <td>LDAP_INVALID_SYNTAX</td>
        <td>Indicates that the attribute value specified in an add, compare, or modify
            operation is an unrecognized or invalid syntax for the attribute.</td>
    </tr>
    <tr>
        <td>22-31</td>
        <td></td>
        <td>Not used.</td>
    </tr>
    <tr>
        <td>32</td>
        <td>LDAP_NO_SUCH_OBJECT</td>
        <td>Indicates the target object cannot be found. This code is not returned on
            following operations: Search operations that find the search base but cannot find
            any entries that match the search filter. Bind operations.</td>
    </tr>
    <tr>
        <td>33</td>
        <td>LDAP_ALIAS_PROBLEM</td>
        <td>Indicates that an error occurred when an alias was dereferenced.</td>
    </tr>
    <tr>
        <td>34</td>
        <td>LDAP_INVALID_DN_SYNTAX</td>
        <td>Indicates that the syntax of the DN is incorrect. (If the DN syntax is
            correct, but the LDAP server&#39;s structure rules do not permit the operation, the
            server returns code 53:  LDAP_UNWILLING_TO_PERFORM.)</td>
    </tr>
    <tr>
        <td>35</td>
        <td>LDAP_IS_LEAF</td>
        <td>Indicates that the specified operation cannot be performed on a leaf entry.
            (This code is not currently in the LDAP specifications, but is reserved for this
            constant.)</td>
    </tr>
    <tr>
        <td>36</td>
        <td>LDAP_ALIAS_DEREF_PROBLEM</td>
        <td>Indicates that during a search operation, either the client does not have
            access rights to read the aliased object&#39;s name or dereferencing is not
            allowed.</td>
    </tr>
    <tr>
        <td>37-47</td>
        <td></td>
        <td>Not used.</td>
    </tr>
    <tr>
        <td>48</td>
        <td>LDAP_INAPPROPRIATE_AUTH</td>
        <td>Indicates that during a bind operation, the client is attempting to use an
            authentication method that the client cannot use correctly. For example, either of
            the following cause this error: The client returns simple credentials when strong
            credentials are required...OR...The client returns a DN and a password for a
            simple bind when the entry does not have a password defined.</td>
    </tr>
    <tr>
        <td>49  </td>
        <td>LDAP_INVALID_CREDENTIALS</td>
        <td>Indicates that during a bind operation one of the following occurred: The
            client passed either an incorrect DN or password, or the password is incorrect
            because it has expired, intruder detection has locked the account, or another
            similar reason. See the data code for more information.</td>
    </tr>
    <tr>
        <td>49 / 52e</td>
        <td>AD_INVALID CREDENTIALS</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext error, which is
            returned when the username is valid but the combination of password and user
            credential is invalid. This is the AD equivalent of LDAP error code 49.</td>
    </tr>
    <tr>
        <td>49 / 525</td>
        <td>USER NOT FOUND</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext data error that is
            returned when the username is invalid.</td>
    </tr>
    <tr>
        <td>49 / 530</td>
        <td>NOT_PERMITTED_TO_LOGON_AT_THIS_TIME</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext data error that is
            logon failure caused because the user is not permitted to log on at this time.
            Returns only when presented with a valid username and valid password
            credential.</td>
    </tr>
    <tr>
        <td>49 / 531</td>
        <td>RESTRICTED_TO_SPECIFIC_MACHINES</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext data error that is
            logon failure caused because the user is not permitted to log on from this
            computer. Returns only when presented with a valid username and valid password
            credential.</td>
    </tr>
    <tr>
        <td>49 / 532</td>
        <td>PASSWORD_EXPIRED</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext data error that is a
            logon failure. The specified account password has expired. Returns only when
            presented with valid username and password credential.</td>
    </tr>
    <tr>
        <td>49 / 533</td>
        <td>ACCOUNT_DISABLED</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext data error that is a
            logon failure. The account is currently disabled. Returns only when presented with
            valid username and password credential.</td>
    </tr>
    <tr>
        <td>49 / 568</td>
        <td>ERROR_TOO_MANY_CONTEXT_IDS</td>
        <td>Indicates that during a log-on attempt, the user&#39;s security context
            accumulated too many security IDs. This is an issue with the specific LDAP user
            object/account which should be investigated by the LDAP administrator. </td>
    </tr>
    <tr>
        <td>49 / 701</td>
        <td>ACCOUNT_EXPIRED</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext data error that is a
            logon failure. The user&#39;s account has expired. Returns only when presented with
            valid username and password credential.</td>
    </tr>
    <tr>
        <td>49 / 773</td>
        <td>USER MUST RESET PASSWORD</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext data error. The
            user&#39;s password must be changed before logging on the first time. Returns only
            when presented with valid user-name and password credential.</td>
    </tr>
    <tr>
        <td>50</td>
        <td>LDAP_INSUFFICIENT_ACCESS</td>
        <td>Indicates that the caller does not have sufficient rights to perform the
            requested operation.</td>
    </tr>
    <tr>
        <td>51</td>
        <td>LDAP_BUSY</td>
        <td>Indicates that the LDAP server is too busy to process the client request at
            this time but if the client waits and resubmits the request, the server may be
            able to process it then.</td>
    </tr>
    <tr>
        <td>52</td>
        <td>LDAP_UNAVAILABLE</td>
        <td>Indicates that the LDAP server cannot process the client&#39;s bind request,
            usually because it is shutting down.</td>
    </tr>
    <tr>
        <td>52e</td>
        <td>AD_INVALID CREDENTIALS</td>
        <td>Indicates an Active Directory (AD) AcceptSecurityContext error, which is
            returned when the username is valid but the combination of password and user
            credential is invalid. This is the AD equivalent of LDAP error code 49:
            LDAP_INVALID_CREDENTIALS.</td>
    </tr>
    <tr>
        <td>53</td>
        <td>LDAP_UNWILLING_TO_PERFORM</td>
        <td>Indicates that the LDAP server cannot process the request because of
            server-defined restrictions. This error is returned for the following reasons: The
            add entry request violates the server&#39;s structure rules...OR...The modify
            attribute request specifies attributes that users cannot modify...OR...Password
            restrictions prevent the action...OR...Connection restrictions prevent the
            action.</td>
    </tr>
    <tr>
        <td>54</td>
        <td>LDAP_LOOP_DETECT</td>
        <td>Indicates that the client discovered an alias or referral loop, and is thus
            unable to complete this request.</td>
    </tr>
    <tr>
        <td>55-63</td>
        <td></td>
        <td>Not used.</td>
    </tr>
    <tr>
        <td>64</td>
        <td>LDAP_NAMING_VIOLATION</td>
        <td>Indicates that the add or modify DN operation violates the schema&#39;s structure
            rules. For example, The request places the entry subordinate to an alias. The
            request places the entry subordinate to a container that is forbidden by the
            containment rules. The RDN for the entry uses a forbidden attribute type.</td>
    </tr>
    <tr>
        <td>65</td>
        <td>LDAP_OBJECT_CLASS_VIOLATION</td>
        <td>Indicates that the add, modify, or modify DN operation violates the object
            class rules for the entry. For example, the following types of request return this
            error: The add or modify operation tries to add an entry without a value for a
            required attribute. The add or modify operation tries to add an entry with a value
            for an attribute which the class definition does not contain. The modify operation
            tries to remove a required attribute without removing the auxiliary class that
            defines the attribute as required.</td>
    </tr>
    <tr>
        <td>66</td>
        <td>LDAP_NOT_ALLOWED_ON_NONLEAF</td>
        <td>Indicates that the requested operation is permitted only on leaf entries. For
            example, the following types of requests return this error: The client requests a
            delete operation on a parent entry. The client request a modify DN operation on a
            parent entry.</td>
    </tr>
    <tr>
        <td>67</td>
        <td>LDAP_NOT_ALLOWED_ON_RDN</td>
        <td>Indicates that the modify operation attempted to remove an attribute value
            that forms the entry&#39;s relative distinguished name.</td>
    </tr>
    <tr>
        <td>68</td>
        <td>LDAP_ALREADY_EXISTS</td>
        <td>Indicates that the add operation attempted to add an entry that already
            exists, or that the modify operation attempted to rename an entry to the name of
            an entry that already exists.</td>
    </tr>
    <tr>
        <td>69</td>
        <td>LDAP_NO_OBJECT_CLASS_MODS</td>
        <td>Indicates that the modify operation attempted to modify the structure rules
            of an object class.</td>
    </tr>
    <tr>
        <td>70</td>
        <td>LDAP_RESULTS_TOO_LARGE</td>
        <td>Reserved for CLDAP.</td>
    </tr>
    <tr>
        <td>71</td>
        <td>LDAP_AFFECTS_MULTIPLE_DSAS</td>
        <td>Indicates that the modify DN operation moves the entry from one LDAP server
            to another and requires more than one LDAP server.</td>
    </tr>
    <tr>
        <td>72-79</td>
        <td></td>
        <td>Not used.</td>
    </tr>
    <tr>
        <td>80</td>
        <td>LDAP_OTHER</td>
        <td>Indicates an unknown error condition. This is the default value for NDS error
            codes which do not map to other LDAP error codes.</td>
    </tr>
    <tr>
        <td>10000</td>
        <td>LDAP_ERROR_GENEREL</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10001</td>
        <td>LDAP_ERROR_MAL_FORMED_URL</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10002</td>
        <td>LDAP_ERROR_UNAUTHENTICATED_BIND</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10300</td>
        <td>LDAP_ERROR_COMMUNICATION_EXCEPTION</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10301</td>
        <td>LDAP_ERROR_SOCKET_TIMEOUT</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10302</td>
        <td>LDAP_ERROR_CONNECTION_REFUSED</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10303</td>
        <td>LDAP_ERROR_CONNECTION_RESET</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10304</td>
        <td>LDAP_ERROR_NO_ROUTE</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10305</td>
        <td>LDAP_ERROR_UNKNOW_HOST</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10400</td>
        <td>LDAP_ERROR_SSL_EXCEPTION</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10401</td>
        <td>LDAP_ERROR_SSL_EMPTY_CERT_STORE</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10402</td>
        <td>LDAP_ERROR_SSL_CERT_NOT_FOUND</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10403</td>
        <td>LDAP_ERROR_SSL_CERT_EXPIRED</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>10500</td>
        <td>LDAP_ERROR_INVALID_SEARCH_FILTER_EXCEPTION</td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>