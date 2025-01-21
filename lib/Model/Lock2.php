<?php
/**
 * Lock2
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * iLOQ Public API
 *
 * Public API for iLOQ 5 Series locking system.   # Introduction This is OpenApi documentation for iLOQ Public API.   Service is REST (Representational state transfer).  Protocol used to transport the data is HTTP and JSON is used for data transfer.  Below is important information and notes about some business related concepts that have already been covered in you iLOQ training.  ## Calendar reservations  Below is a chart that illustrates relations between calendars and network module components.  ![Calendar chart](/iLOQPublicApiDoc/images/iLOQ_API_Chart.png)  ## Time limits  <h3> General information </h3>  Time limits are used to define when a key has access to a lock. Time limits are stored in the key.  Terms explained  * Time limit slot is a memory slot in a key.  * Time profile is a time limit slot that has a weekly clock.  * Time limit title is a preconfigured time profile that can be added to a key  * Time limit data is the weekly clock of a time profile  <h4> Time limit slot </h4> A key's time limit slot is either the key's start date, end date or a time profile added to the key.   <h4> Time profile</h4> Time profile need to be preconfigured in the locking system before it can be added to a key. This is done by creating a TimeLimitTitle. When adding time profiles to a key, you need to provide the TimeLimitTitle_ID of the preconfigured time profile you want to add. Time profiles can be either fixed or editable.  <li>Fixed time profiles cannot be modified as they are being added to the key. </li>  <li>Editable time profiles can be modified as they are being added to the key.</li>      When adding fixed time profiles, the TimeLimitTitle start- and end dates and the weekly clocks need to be set with identical values to the preconfigured time profile.  * The weekly clock start- and end times are in milliseconds. You will need to convert the time to milliseconds when adding time profiles to a key.   <h4> Time limit title</h4> Time limit title can be either a fixed or editable time profile. You need to create a time limit title before you can add time profiles to a key.  **[POST /api/v2/TimeLimitTitles](#operation/TimeLimitTitles_Insert)**.  <h4> Time limit data</h4> Time limit data is the weekly clock of a time profile. Do not add time limit data to a time limit slots 0 or 1.   <h3>Limitations to be considered</h3>  Take into account that physical key has hardware limitations.  Depending on locks versions, keys have max 10 up to 23 memory slots. This limits how many time limits can be stored to the key. C5 locks require minimum firmware version 138 and D5 locks require minimum firmware version 135 to support over 10 time limits.  Memory slot usage * Start date takes one slot  * End date takes one slot  * Time profiles can take multiple slots     * Time profile start date takes one slot     * Time profile end date takes one slot     * Each time limit data takes one slot  <h3> Key start date and end date -- slots 0 and 1 </h3>  Key's start and end date are stored in slots 0 and 1. These slots cannot be modified with any other endpoint than **[PUT /api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)**.  Common use cases: - An employee's employment start and end date.  - The time period when a technician has access to a certain site. - A simple calendar reservations. For example, a single sports hall reservation on Friday 20.10.2023 from 19:00 to 23:00.  Example payload ``` {     \"TimeLimitSlots\": [         {             \"LimitDateLg\": \"2022-05-01T10:00:00\",             \"SlotNo\": 0         },         {             \"LimitDateLg\": \"2022-06-30T18:00:00\",             \"SlotNo\": 1         }     ] } ```   <h3>Key time profiles -- slot 2</h3>  Common use cases are for example: - Key holder makes a reservation in the calendar of a third party system and a time profile is added to the key. Time profile has start and end time. - Recurring calendar reservation. In addition to start and end time, a weekly clock is added to the time profile. - An employee transfered to a remote office for several days, but having access to office only on weekdays during office hours 08:00-16:00. - Access to an office is limited to weekdays between 07:00 and 17:00.  Example payload ``` {   \"TimeLimitSlots\": [         {             \"SlotNo\": 2,    \"TimeLimitTitle_ID\":\"84c737d4-121e-4e4b-87f1-0d869a3fb161\",    \"TimeLimitData\": [     {      \"EndTimeMS\": 62100000,      \"StartTimeMS\": 31500000,      \"WeekDayMask\": 16     },     {      \"EndTimeMS\": 57600000,      \"StartTimeMS\": 28800000,      \"WeekDayMask\": 31     }             ]         }     ] } ```  Example payload with start and end dates, fixed and editable time profiles. ``` {     \"TimeLimitSlots\": [         {             \"SlotNo\": 2,             \"TimeLimitData\": [                 {                     \"WeekDayMask\": 31,                     \"StartTimeMS\": 32400000,                     \"EndTimeMS\": 61200000                 }             ],             \"TimeLimitTitle_ID\": \"a4da99c5-102e-46f8-a64b-a51bcd5cb42b\",             \"TimeLimitTitleEndDateLg\": \"2022-06-15T19:30:00\",             \"TimeLimitTitleStartDateLg\": \"2022-06-01T04:00:00\"         },         {             \"SlotNo\": 2,             \"TimeLimitData\": [                 {                     \"WeekDayMask\": 31,                     \"EndTimeMS\": 57600000,                     \"StartTimeMS\": 28800000                                     }             ],             \"TimeLimitTitle_ID\": \"103287c6-0757-4dec-b993-7b3fd616ae77\",         },         {             \"LimitDateLg\": \"2022-05-01T10:00:00\",             \"SlotNo\": 0,         },         {             \"LimitDateLg\": \"2022-06-30T18:00:00\",             \"SlotNo\": 1,         }     ] } ```  Notes: - Remember to use correct slot numbers. SlotNo 0 is for start date, SlotNo 1 is for end date and SlotNo 2 is for time profiles. - Request datetimes in format \"yyyy-MM-ddTHH:mm:ss\" using in locking system time zone. - When editing time limit slots using **[PUT /api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)** endpoint, remember to include all the needed slots, including start date, end date and time profiles. <b>All the ones you omit will be deleted from the key.</b>     * Also, remember to include any used security access ids in the SecurityAccessIds array. <b>Otherwise they will be deleted from the key.</b> - For complex time limit configurations try use iLOQ 5 Series Manager create these time limits. Then request **[GET Keys/{id}/TimeLimitTitles](#operation/Keys_GetTimeLimits)** to see how payloads of keys' time profiles should be defined.  ## Phone keys  Phone keys can be created and programming tasks ordered through Public API.  Phone S50 app gets the programming task, programs itself, reports to server and after that, phone key is programmed.    ### Creating a new phone key to locking system  First create a new phone key by requesting **[POST api/v2/Keys](#operation/Keys_Insert)**.  <br> KeyTypeMask for phone key is 6 (S50 + PhoneKey).   Then update phone key information with phone number or email for registration SMS or email by requesting **[PUT api/v2/KeyPhones](#operation/KeyPhones_Update)**.   ### Setting main zone for the phone key  Check if main zone can be updated to the key by calling **[GET api/v2/Keys/{id}/CanUpdateMainZone](#operation/Keys_CanUpdateKeyMainZone)**. <br>  If main zone can be updated, update by calling **[POST api/v2/Keys/{id}/UpdateMainZone](#operation/Keys_UpdateKeyMainZone)**.   ### Adding access rights and time profiles for the phone key  Check first if access right can be added to the key by **[GET api/v2/Keys/{id}/SecurityAccesses/CanAdd](#operation/Keys_CanAddSecurityAccess)**.  <br>  Add access rights by calling **[POST api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_InsertSecurityAccess)**. <br>  Check first if time profile can be added to the key by **[POST api/v2/Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**.  <br>  Add time profiles by calling **[POST api/v2/Keys/{id}/TimeLimitTitles](#operation/Keys_InsertTimeLimitTitle)**.   ### First time registration and ordering programming task  Check if programming can be ordered through API by calling **[GET api/v2/Keys/{id}/CanOrder](#operation/Keys_CanOrderKey)**.   <br>  Do this step always before ordering programming task. <br>  Order programming task for this new key by calling **[POST api/v2/Keys/{id}/Order](#operation/Keys_OrderKey)**.    ## External RFID tag keys  External RFID tag keys can be created and instantly programmed on server side through Public API.   ### Creating a new external tag key to locking system  First create a new external tag key by requesting **[POST api/v2/Keys](#operation/Keys_Insert)**. <br>   When creating a new key, KeyTypeMask for external RFID tag key is 384 (5 Series + Other than iLoq physical key).   ### Setting main zone for the external tag key  Check if main zone can be updated to the key by calling **[GET api/v2/Keys/{id}/CanUpdateMainZone](#operation/Keys_CanUpdateKeyMainZone)**. <br>  If main zone can be updated, update by calling **[POST api/v2/Keys/{id}/UpdateMainZone](#operation/Keys_UpdateKeyMainZone)**.   ### Adding access rights and time profiles for the external tag key  Check first if access right can be added to the key by **[GET api/v2/Keys/{id}/SecurityAccesses/CanAdd](#operation/Keys_CanAddSecurityAccess)**.  <br>  Add access rights by calling **[POST api/v2/Keys/{id}/SecurityAccesses](#operation/Keys_InsertSecurityAccess)**. <br>  Check first if time profile can be added to the key by **[POST api/v2/Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**.  <br>  Add time profiles by calling **[POST api/v2/Keys/{id}/TimeLimitTitles](#operation/Keys_InsertTimeLimitTitle)**.   ### Program the external RFID tag key  Check if programming can be ordered through API by calling **[GET api/v2/Keys/{id}/CanOrder](#operation/Keys_CanOrderKey)**.   <br>  Do this step always before ordering programming task. <br>  Order programming task for this new key by calling **[POST api/v2/Keys/{id}/Order](#operation/Keys_OrderKey)**.  RFID external tg gets programmed on the server side and is ready to use. After programming, KeyTypeMask for external RFID tag key is 400 (5 Series + Other than iLoq physical key + Classic Mifare rfid).   ## Returning the keys through API  Only S50 phone keys external RFID tag keys can be returned through API. Other types of keys require iLOQ 5 series Manager + programming key to return. Returning the key through API also deletes it from system.  Returning the key does not require separate **DELETE api/v2/Keys/{id}** request.   You can check if key can be returned through API by calling  **[GET api/v2/Keys/{id}/CanReturn](#operation/Keys_CanReturnKey)**.   If CanReturn reponse indicates that key can be returned with API then call **[POST api/v2/Keys/{id}/Return](#operation/Keys_ReturnKey)**.  If returning is not possible, see CanReturn response for further information.   Public API also supports deleting the keys. If key has been programmed or issued to programming it cannot be deleted from locking system anymore. Try instead returning. <br> Check first if key can be deleted calling **[GET api/v2/Keys/{id}/CanDelete](#operation/Keys_CanDeleteKey)**. <br> If response 0 Key can be deleted then proceed to call **[DELETE api/v2/Keys/{id}](#operation/Keys_Delete)**.  Any kind of non-programmed key type can be deleted throught API.    # Public API ## API Documentation This OpenApi 3.0 documentation is for Public API version 2 for 5 Series locking systems. Other locking systems should use version 1.  For other versions use this endpoint documentation: https://s10.iloq.com/iloqwsapi/help   OpenApi Json document can be used to generate client library in multiple programming languages (C#, java, javascript, etc.). For more information about swagger, visit https://swagger.io/  ## Usage  To use the API, you first need to make sure your locking system is API enabled. If it isn't enabled, an error will occur during login. You can view if your locking system is API enabled by logging into 5 Series Manager and going to Edit locking system information window and then selecting Settings tab. A checkbox will appear if API is enabled. For further assistance, please contact iLOQ. Contact information can be found at https://www.iloq.com/en/sales/iloq-sales-support/  Before starting, it is recommended to get familiar with the general idea and principles behind iLOQ's locking system. You can contact iLOQ to book a training course about the locking system and iLOQ Manager software. This training takes from half a day to a day. Here is also some reading about the locking system:  * S10: https://www.iloq.com/manual/en/s10/ * 5 Series: https://www.iloq.com/manual/en/5-series/  The API is a RESTful service. Endpoints can be called with simple HTTP calls and HTTP protocols are mapped to CRUD operations:  * GET will retrieve data * PUT updates data * POST inserts new data (sometimes also used to just retrieve data if complex parameter is required) * DELETE deletes data  # Getting started   **NOTE! Headers** <br> In all API calls, the Http header called **\"SessionId\"** is mandatory after step 2 Create session.<br> If you are using API Gateway, the header **\"x-api-key\"** must be included for every request.  Those header values you get from here:  * SessionID value from Create Session request * x-api-key value from API Developer Portal on My Dashboard-Page.   ## General process Using iLOQ Public API is a six step process.  ![Session handling chart](/iLOQPublicApiDoc/images/session_handling.png)   | Steps                  |                                                | | ---------------------- |------------------------------------------------| | 1. Resolve url         | Resolves which server url to use               | | 2. Create session      | Creates session                                | | 3. Get locking systems | Returns locking systems user has rights to use | | 4. Set locking system  | Logging to locking system                      | | 5. Call endpoints      | Use endpoints to manage locking system         | | 6. Kill session        | Terminates session after it's no longer needed |  ## 1. Resolve url First step is to get the correct url to use for the rest of the API calls.  Use your iLOQ Manager server url to call **[POST Url/GetUrl](#operation/Url_GetUrl)** endpoint with customer code. This endpoint returns you rest of url.  Calling this endpoint and resolving the url makes sure your application always uses the correct url to access the API.  Usually your iLOQ Manager server url is:  * https://s5.iloq.com/iloqws  * https://s5.iloq.de/iloqws  For example, after calling https://s5.iloq.com/iloqws/api/v2/Url/GetUrl endpoint, you might get https://s5.iloq.com/iloqwspool2/ as response. Use this new url to call rest of the API endpoints, e.g. https://s5.iloq.com/iloqwspool2/api/v2/CreateSession.  **NOTE!** If GetUrl returns a null or empty string, use original url that you used in **[POST Url/GetUrl](#operation/Url_GetUrl)** request to call rest of the endpoints. Do not skip this first part in your integration, even if **[POST Url/GetUrl](#operation/Url_GetUrl)** seems to always to return empty string.   ## 2. Create session After resolving the url, you can log in. Logging in must be done before calling any other API endpoint. This is done by calling **[POST CreateSession](#operation/Authentication_CreateSession)** endpoint with credentials.  | Credentials   | Description                        | | ------------- |----------------------------------- | | UserName      | User name                          | | Password      | Password                           | | CustomerCode  | Customer code                      | | ApiKey        | Leave empty for now                | | ApiSecret     | Leave empty for now                |   Call returns response token with SessionId and result which tells if the session creation was successful. This token has to be used in all API calls in Http header called \"SessionId\". ## 3. Get locking systems After retrieving session id successfully, you need to set the locking system user uses for the duration of this session. Persons, keys, locks and other resources are always linked to a locking system. Before they can be accessed, user must be authenticated to a locking system.    First you need to get all the locking systems user has rights to. Call **[GET LockGroups](#operation/LockGroups_GetAllLockGroups)** endpoint to get all locking systems that user has rights. Resultset contains one or more locking systems. If only one locking system is returned, that can be used directly. Otherwise show locking systems to end user and let user to choose locking system. ## 4. Set locking system To Authenticate to selected locking system call **[POST SetLockgroup](#operation/Authentication_SetLockgroup)** with the chosen locking system.   SetLockgroup returns user's permission rights. You can use this bit mask value to enable/disable certain actions in your software. For example, if your application is used to book times using a calendar and user doesn't have permission to edit calendars (CanEditCalendars (2251799813685248)), you can disable calendar edit controls.  Now user can call the rest of the API endpoints. ## 5. Call endpoints Call endpoints to manage locking system. ## 6. Kill session Lastly when you have finished using Public API endpoints, terminate session with **[GET KillSession](#operation/Authentication_KillSession)**. # Samples ## Common use cases These samples describe what endpoints and in which order to call them. These use cases do not provide parameters or responses.  * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_BlacklistingKeys.html\" target=\"_blank\">Blocklisting keys</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_CalendarSecurityAccessGroup.html\" target=\"_blank\">Code access groups to calendar controls</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_SessionAndLogging.html\" target=\"_blank\">Creating session and logging to locking system</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_Calendars.html\" target=\"_blank\">Managing calendars and time controls</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCalendarControlledDoors.html\" target=\"_blank\">Manage calendar controlled doors</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCalendarControlledDoorsSecurityCode.html\" target=\"_blank\">Manage calendar controlled doors with code access groups</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingCodeAccesGroups.html\" target=\"_blank\">Manage code access groups</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManangingKeys.html\" target=\"_blank\">Managing keys</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManageKeysSecurityAccessesRemotely.html\" target=\"_blank\">Manage key's security accesses remotely</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManageLocksSecurityAccessesRemotely.html\" target=\"_blank\">Manage lock's security accesses remotely</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingPersons.html\" target=\"_blank\">Manage persons</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_OrderingPhoneKeys.html\" target=\"_blank\">Managing phone keys</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_OrderingRFIDKeys.html\" target=\"_blank\">Managing external RFID tags</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingSecurityAccesses.html\" target=\"_blank\">Manage security accesses</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_ManagingTimeLimits.html\" target=\"_blank\">Manage time profiles</a> * <a href=\"/iLOQPublicApiDoc/use_cases/iLOQ_S5KeyTimeProfiles.html\" target=\"_blank\">Manage time restrictions for iLOQ S5 keys</a>  ## UWP application Sample project is an UWP application written In C#. Project can be downloaded from **<a href=\"iLOQPublicApiDoc/use_cases/PublicApiUseCases.zip\">here</a>**. It shows you how to login to a locking system and it also covers these common use cases:  * Transferring person data from your system to iLOQ. * Making calendar reservations for common area, like laundry room or sauna. * Adding and configuring S5 keys for tenants. * Managing iLOQ S50 phone keys.  # Change history  ## Version 7.5  * New features      * Public API now supports creating, ordering, programming and returning external RFID tags       * Sample lists of requests can be found **[in samples section](#section/Samples/Common-use-cases)**.       * More about programming of external RFID tag keys can be found **[here](#section/Introduction/External-RFID-tag-keys)**.     * New endpoints     * **[GET Keys/{id}/LocationReporting](#operation/Keys_GetKeyLocationReportingInAuditTrail)**       * Query if phone key records the last known valid location of mobile device to audit trail during lock open event.     * **[PUT Keys/{id}/LocationReporting](#operation/Keys_SetKeyLocationReportingInAuditTrail)**       * Set if you want phone key to record the last known valid location of mobile device to audit trail during lock open event.  ## Version 7.4   * New endpoints     * **[POST Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)**       * This endpoint will replace previous version that was HTTP GET method     * **[GET PersonRoles/{id}/SecurityAccesses](#operation/PersonRoles_GetSecurityAccessesByPersonRoleId)**       * Gets security accesses by person role  ## Version 7.1.8200.35003    * New features     * **[New webhook event for subcribing lock logs.](#section/Webhook-(Beta)/Events)**         * This new feature will replace SignalR.          * Locks real estate can be updated through **[PUT Locks](#operation/Locks_Update)** -endpoint        * Enum values and descriptions for **[Locks](#operation/Locks_GetLockById)** **PhysicalState** property     * **[GET Keys/{id}/TimeLimitTitles/CanAdd](#operation/Keys_CanAddTimeLimitTitle)** has new return value CanAddTimeLimit     * Two new read only properties for **[Keys](#operation/Keys_GetKey)**         * **ProgrammingState** of the key. This new field equivalent to 5 series Manager's Programming State -field.           * **IsProgrammed** has key ever been programmed.              * New endpoints      * **[GET Persons/{id}/NortecActivationCode](#operation/Persons_GetNortecCode)**       * Gets Nortec laundry code      * **[GET Webhooks/Subscriptions/{id}/Payloads](#operation/Webhooks_GetPayloadsForSubscription)**       * Gets payloads which have the given state. Returns most recent, maximum of 1000 payloads.     * **[GET Webhooks/Subscriptions/PendingPayloads](#operation/Webhooks_GetSubscriptionsWithPendingPayloads)**       * Gets webhook subscriptions which have sent payloads that aren't sent successfully (state = 3 or 4).    ## Version 6.9.1.0   * **Breaking changes**     * From this version on **S50 phone keys require Person_ID -link**. Inserting and updating phone key without person link will cause validation error and key will not be inserted or updated.  * New endpoints for key's security access and time profile management     * Key's security access management         * **[Can security access to be added to key](#operation/Keys_CanAddSecurityAccess)**         * **[Add security access to key](#operation/Keys_InsertSecurityAccess)**         * **[Can security access to be deleted from key](#operation/Keys_CanDeleteSecurityAccess)**         * **[Delete security access from key](#operation/Keys_DeleteSecurityAccess)**      * Key's time profile management         * **[Can time profile to added to key](#operation/Keys_CanAddTimeLimitTitle)**         * **[Add time profile to key](#operation/Keys_InsertTimeLimitTitle)**         * **[Modify key's time profile](#operation/Keys_UpdateTimeLimit)**         * **[Get information of key's time profile](#operation/Keys_GetTimeLimit)**         * **[Delete time profile from key](#operation/Keys_DeleteTimeLimit)**      * **[PUT Keys/{id}/SecurityAccesses](#operation/Keys_UpdateSecurityAccesses)** works as before  * New read-only property **TagKeyHex** for Keys     * RFID Tag presented as HEX. Empty if TagKey is absent.   ## Version 6.8.0.16  * **[Webhook (Beta)](#section/Webhook-(Beta))**     * Webhooks allows subscribing to events happening in iLOQ Manager and iLOQ Public Api  * New endpoint for **[re-registering phone keys](#operation/KeyPhones_SendPhoneRegistration)**   ## Version 6.5.0.1   * New endpoints **[KeyTag](#tag/KeyTags)**     * Ticketing support   # General advice and FAQ   In this section you can find few useful tips and FAQ for using iLOQ API.   ## API * Locking system has to be API enabled. See more in **[here](#section/Public-API/Usage)**. * To make changes to key's security accesses and order them via API, type of the security acceess that is being changed, has to be API access. Changes to Standard access require Manager and Token to order.   ## Can-methods  * iLOQ Public API provides several CanAdd, CanAddKey, CanRemoveKey, CanRemove, CanOrder, CanReturn -methods. These endpoints may provide usefull information why something cannot be done. It also prevents unsuccessfull POST and DELETE requests.   ## GUIDs and ID fields * General rule is that integrator defines new GUIDs for ID fields for POST requests. * Some POST endpoints may generate GUID or add 00000000-0000-0000-0000-000000000000 as GUID, but generate your own GUIDs also in these cases.  ## KeyTypeMask * KeyTypeMask describes type of the key. * Accepts the following combinations: S10 + iLoqKey (S10 key), S50 + PhoneKey (S50 phone key), S50 + iLoqKey (S50 fob key), 5 Series + iLoqKey (S5 key), 5 Series + Other than iLoq physical key (External RFID tag key).  ## Logging * We strongly advice to have sufficient logging on your side of integration. For security reasons iLOQ Public API does not log or store payloads of **successfull requests**. Errors are always logged in iLOQ Public API.  ## Rights * Locking system administrator grants user rights for API user when creating user. * Successfully logging to locking system with [POST SetLockgroup](#operation/Authentication_SetLockgroup) return RightsMask that contains user's rights as a bit mask. List of rights can be found [SetLockgroup](#operation/Authentication_SetLockgroup). * Contact your locking system administrator concerning insuffient user rights.  ## Terms   Here is some term differences between iLOQ 5 series Manager and iLOQ Public API  |Manager              |Public API | | --------------------|-------------------------| |Access rights        |SecurityAccesses         | |Blocklist            |Blacklist                | |Calendar             |CalendarDataTitles       | |Calendar control     |CalendarData             | |Code access groups   |SecurityRoles            | |Service code         |CustomerCode             | |Time profile         |TimeLimitTitles          |   # Contact For API support, contact api.support@iloq.com.  In problem situations provide **payloads**, possible **error responses** and **service code** to hasten support.  For non-API-related issues (like contract issues), contact other supports which can be found at https://www.iloq.com/en/sales/iloq-sales-support/  # Webhook (Beta)  Webhooks allow you to build or set up integrations in a loosely coupled manner. Webhooks are created by subscribing to certain events happening in iLOQ. When one of those events is triggered, we will send a `HTTP POST` payload to the URL that has been provided by you.  Once the subscription is created and active, payload will be sent each time the subscribed event occurs.  Up to **3** subscriptions can be created for each event per locking system.  <h3>Subscription</h3>  When creating a subscription, you define which event you're interested in and `http(s)://` endpoint where the payload will be sent. Following information needs to be provided: 1. Endpoint URL that accepts `HTTP POST` requests 2. Starting date and time; when will this subscription start sending payloads 3. Ending date and time; when will this subscription stop sending payloads. Maximum is one year ahead. 4. Event; what occurring event will send the payload 5. Subscription Id; guid generated by you 6. *Custom header (Optional)*; free text that will be sent as part of the payload header 7. *JSON path filter (Optional)*; filter out data you are not interested in  <h4>JSON path filter</h4>  `JSON path filter` -property allows you to filter out events by using [JSON path](https://tools.ietf.org/id/draft-goessner-dispatch-jsonpath-00.html). For example, by giving the following value `$[?($.KeyTypeMask == 9 || $.KeyTypeMask == 4)]`, you receive only payloads that have `KeyTypeMask` with value `4 or 9`, the rest will be ignored. See _Events and Payloads_ for property names that can be used to filter out the webhooks.  <h3>Event</h3>  Each event corresponds to a certain action that can happen within your iLOQ environment. For example, if you subscribe to the `key_added` event, you will receive detailed payload every time an key has been added via iLOQ manager or iLOQ Public api. If you are interested in only certain keys, you can use Json path filter to filter the events.  For a complete list of available webhook events and their payloads, see _Events and Payloads_  <h3>Preparing to receive webhooks</h3>  Provide a public RESTFUL endpoint that accepts the `HTTP POST` requests. If you use `HTTPS`, make sure the certification is correctly setup and matches your domain. Design your endpoint in asynchronous manner. For ex. provide response with a http status code `2xx` instantly and do long-running tasks in the background. Format of the response is irrelevant, but it will be persisted for troubleshooting purposes and the content size is limited to `1MB`  <h3>Error handling & limitations</h3>  If the payload sent by iLOQ does not succesfully complete, iLOQ will try to resend the payloads in a following manner:  |Failed attempts|Delay| |--|--| |1|5 minutes| |2|15 minutes| |3|1 hour| |4|6 hours| |5|12 hours| |6|24 hours|  This totals 7 requests, after that has been reached, this specific event is marked as obsolete and iLOQ stops sending the payload.  For troubleshooting purposes, each unique webhook (and related response given by your endpoint) is persisted for `30 days` and permanently removed after that threshold is reached  <h3>Errors in response</h3>  Webhook sender will check the status code endpoint gives in the response. If the response contains status code that's something else than 2xx, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4>Timeout</h4>  Webhook sender will timeout after **5** seconds if no response is given. Prepare your receiving endpoint in a asynchronous manner so that you can provide the response as soon as possible. If timeout occurs, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4>SSL verification error</h4>  If HTTPS-address is used and SSL verification fails, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4>Host unreachable</h4>  If host is unreachable, this specific event is marked as failed and iLOQ will try resending the payload later.  <h4> Payload common properties </h4>  Each webhook sent by iLOQ has content-type of `application/json; charset=utf-8` and contains following common properties:  <h4>Headers</h4>  |Key|Type|Description|Example |--|--|--|--| |Counter|number|Incremental counter that shows how many unique payloads has been sent to the endpoint provided in the subscription.<br><br>**Important:** Resent requests won't increase the count|2342| |Event-Name|string|Name of the event|key_added| |Subscription-Id|string|Subscription Id that was provided when creating the subscription|90B3B527-3667-4CF8-9930-5D744E5EA877| |Webhook-Signature|string|[Webhook Signature](https://dev.azure.com/SebittiiLOQ/iLOQWebhook/_wiki/wikis/iLOQWebhook-dokumentaatio/41/Webhook-Signature) related to this payload|3133e11d8b3087cf5c2b33c2c14ce4701f5b31a4746f9245681be32449958930| |Custom-Header|string<br>*optional*|Free text given for the subscription. Is delivered as Base64 encoded string|dGVzdA==  <h4>Payload body</h4>  |Key|Type|Description|Example| |--|--|--|--| |Data|object|Event related data provided<br><br>See *Events* for detailed descriptions for each event|{\"Description\": \"string\",\"ExpireDate\": \"2021-04-20T10:42:40.803Z\",\"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"InfoText\": \"string\", \"KeyTypeMask\": 0, \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\", \"ROM_ID\": \"string\", \"Stamp\": \"string\", \"StampSource\": 0, \"State\": 0, \"TagKey\": \"string\", \"TagKeySource\": 0, \"VersionCode\": \"string\"} |CreationTimeUtc|string|UTC timestamp when the payload was sent|2021-04-29T09:08:31.6653347Z  ## Events Each event has unique Data provided within the payload's `BODY`  ### key_added  Key added event occurs, when new key has been added via iLOQ Manager or iLOQ Public api  |Key|Type|Description| |--|--|--| |Description|string|Description text| |ExpireDate|string?|Expiration date. Null if the key doesn't expire| |FNKey_ID|string(Guid)|Key Id| |InfoText|string|Additional info text| |KeyTypeMask|number|Key's types in bitmask| |Person_ID|string?(Guid)|Person to whom the key is linked to. Null if the key isn't linked to anyone| |RealEstate_ID|string(Guid)|Id of the real estate where this key belongs to| |ROM_ID|string|ROM ID| |Stamp|string|Number consisting of 4 digits written to the physical key| |StampSource|number|The source of the key labeling (Stamp)| |State|number|Current state| |TagKey|string|RFID Tag. Empty string if not given| |TagKeySource|int|The source of the key's tagkey enumeration| |VersionCode|string|Version information|  Key Added payload example (prettified)  ``` {   \"Data\": {     \"Description\": \"string\",     \"ExpireDate\": \"2021-04-20T10:42:40.803Z\",     \"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"InfoText\": \"string\",     \"KeyTypeMask\": 0,     \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"ROM_ID\": \"string\",     \"Stamp\": \"string\",     \"StampSource\": 0,     \"State\": 0,     \"TagKey\": \"string\",     \"TagKeySource\": 0,     \"VersionCode\": \"string\"   },   \"CreationTimeUtc\": \"2021-04-27T14:54:06.747\" } ```  Full Request example ``` POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/key-added HTTP/1.1 Host: 10.0.1.6 Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1 Event-Name: key_added Custom-Header: VGVzdCBoZWFkZXI= Subscription-Id: 449226d9-bb2f-41f2-be90-32ec2b9b00c4 Counter: 5304 Content-Type: application/json; charset=utf-8 Content-Length: 433  {\"Data\":{\"Description\":\"string\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"string\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-04-29T09:08:31.6653347Z\"} ```  ### key_blocklisted  Key blocklisted event occurs, when key has been blocklisted via iLOQ Manager or iLOQ Public api  |Key|Type|Description| |--|--|--| |Description|string|Description text| |ExpireDate|string?|Expiration date. Null if the key doesn't expire| |FNKey_ID|string(Guid)|Key Id| |InfoText|string|Additional info text| |KeyTypeMask|number|Key's types in bitmask| |Person_ID|string?(Guid)|Person to whom the key is linked to. Null if the key isn't linked to anyone| |RealEstate_ID|string(Guid)|Id of the real estate where this key belongs to| |ROM_ID|string|ROM ID| |Stamp|string|Number consisting of 4 digits written to the physical key| |StampSource|number|The source of the key labeling (Stamp)| |State|number|Current state| |TagKey|string|RFID Tag. Empty string if not given| |TagKeySource|int|The source of the key's tagkey enumeration| |VersionCode|string|Version information|  Key Blocklisted payload example (prettified) ``` {   \"Data\": {     \"Description\": \"string\",     \"ExpireDate\": \"2021-04-20T10:42:40.803Z\",     \"FNKey_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"InfoText\": \"string\",     \"KeyTypeMask\": 0,     \"Person_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"RealEstate_ID\": \"3fa85f64-5717-4562-b3fc-2c963f66afa6\",     \"ROM_ID\": \"string\",     \"Stamp\": \"string\",     \"StampSource\": 0,     \"State\": 0,     \"TagKey\": \"string\",     \"TagKeySource\": 0,     \"VersionCode\": \"string\"   },   \"CreationTimeUtc\": \"2021-04-27T14:54:06.747Z\" } ``` Full Request example ``` POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/key-added HTTP/1.1 Host: 10.0.1.6 Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1 Event-Name: key_blocklisted Custom-Header: VGVzdCBoZWFkZXI= Subscription-Id: 3fa85f64-5717-4562-b3fc-2c963f66afa6 Counter: 5304 Content-Type: application/json; charset=utf-8 Content-Length: 433  {\"Data\":{\"Description\":\"string\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"string\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-04-29T09:08:31.6653347Z\"} ```  ### device_log_arrived Device log arrived event occurs, when lock, key or network module sends audit trails or other device logs to server  |Key|Type|Description| |--|--|--| |DeviceLogTypeMask|int|Lock log types as bit mask values. For example 1028 would be successful S10 key access. 12 would be successful phone access etc.| |FLock_ID|string(Guid)?|Id of the lock. Null if the event isn't related to lock| |FNKey_ID|string(Guid)?|Id of the key. Null if the event isn't related to key| |GoingDateUtc|string?|Date and time of log access. Null if the event isn't related to key or lock access| |KeyTypeMask|number?|Key's types in bitmask. Null if the event isn't related to key| |LanguageCode|string?|Language code for person linked to key. Null if the event isn't related to key or this information is not available| |LockSerialNumber|int?|Serial number for the lock. Null if the event isn't related to lock| |Person_ID|string?|Id of the person to whom the key is linked to. Null if the key isn't linked to anyone or the event isn't related to key| |PersonFullName|string)|Full name of the person to whom the key is linked to. Null if the key isn't linked to anyone or the event isn't related to key| |PhoneEmail|string)|Email linked to the phone key. Null if the event isn't related to phone key| |PhoneNo|string)|Phone number linked to the phone key. Null if the event isn't related to phone key| |RealEstate_ID|string?|Id of the real estate where lock belongs to. Null if the event isn't related to lock|  Device Log Arrived payload example (prettified) ``` {   \"Data\": {     \"DeviceLogTypeMask\": 12,     \"FLock_ID\": \"3589CBEB-C801-41C9-BB06-B7A51C1F346B\",     \"fnKey_ID\": \"FD051B34-5DDC-485A-915A-205016EA74D6\",     \"GoingDateUtc\": \"2022-05-09T14:54:06.747Z\",     \"KeyTypeMask\": 4,     \"Person_ID\": \"36FCDD5C-D306-43EC-845D-DB424568F38B\",     \"RealEstate_ID\": \"0565B189-9474-4E06-94F6-DAD33F2863F5\",     \"LanguageCode\": \"FIN\",     \"LockSerialNumber\": 123456,     \"PersonFullName\": \"Foo Bar\",     \"PhoneEmail\": \"foo@domain.com\",     \"PhoneNo\": \"555-12345678\"   },   \"CreationTimeUtc\": \"2022-05-11T14:54:06.747Z\" } ``` Full Request example ``` POST http://10.0.1.6/iLOQWebhookReceiver/api/testing/device-log-arrived HTTP/1.1 Host: 10.0.1.6 Webhook-Signature: 8e67b39b6507f0ac9b559ba9c57a1efb12b40e632eabd99c316213fdaf4261f1 Event-Name: device_log_arrived Custom-Header: VGVzdCBoZWFkZXI= Subscription-Id: 3fa85f64-5717-4562-b3fc-2c963f66afa6 Counter: 1204 Content-Type: application/json; charset=utf-8 Content-Length: 433  {\"Data\":{\"DeviceLogTypeMask\":12,\"FLock_ID\":\"3589CBEB-C801-41C9-BB06-B7A51C1F346B\",\"fnKey_ID\":\"FD051B34-5DDC-485A-915A-205016EA74D6\",\"GoingDateUtc\":\"2022-05-09T14:54:06.747Z\",\"KeyTypeMask\":4,\"Person_ID\":\"36FCDD5C-D306-43EC-845D-DB424568F38B\",\"RealEstate_ID\":\"0565B189-9474-4E06-94F6-DAD33F2863F5\",\"LanguageCode\":\"FIN\",\"LockSerialNumber\":123456,\"PersonFullName\":\"Foo Bar\",\"PhoneEmail\":\"foo@domain.com\",\"PhoneNo\":\"555-12345678\"},\"CreationTimeUtc\":\"2022-05-11T14:54:06.747Z\"} ```  ## Webhook signature  Webhook service will create unique signature for each sent webhook.   By recreating and comparing this hex digest to the one sent within the headers, payload receiver can make sure that the payload has remained intact and is sent from a trusty source.  Signature is within the HEADER `Webhook-Signature`  To recreate this hex digest, you will need following info: * `SignKey` linked to the subscription * `BODY` of the payload  `Webhook-Signature` is the HMAC hex digest of the request body, and is generated using the SHA-256 hash function and the `SignKey` as the HMAC key.  <h3>Example</h3>  Body of the payload:  ```{\"Data\":{\"Description\":\"kuvaus\",\"ExpireDate\":\"2021-04-20T10:42:40.803Z\",\"FNKey_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"InfoText\":\"infoa\",\"KeyTypeMask\":0,\"Person_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"RealEstate_ID\":\"3fa85f64-5717-4562-b3fc-2c963f66afa6\",\"ROM_ID\":\"string\",\"Stamp\":\"string\",\"StampSource\":0,\"State\":0,\"TagKey\":\"string\",\"TagKeySource\":0,\"VersionCode\":\"string\"},\"CreationTimeUtc\":\"2021-01-05T12:15:30Z\"}```  SignKey:  `EFE3FD29-0B3E-405F-98EE-0CC5385DF5D5`  With the above data, following `Webhook-Signature` is generated:  `0468a4741fc1445f9b70805456016c88ad5b61544dd8c38502be546f3e05b4e8`  <h4>Code example (C#)</h4>  ``` public static string ComputeWebhookSignature(string signKey, string body) {     var bytes = Encoding.UTF8.GetBytes(signKey);     using (var hasher = new HMACSHA256(bytes))     {         var data = Encoding.UTF8.GetBytes(body);         return BitConverter.ToString(hasher.ComputeHash(data)).ToLower().Replace(\"-\", \"\");     } } ```  <h3>Additional security</h3>  Each payload body will contain property `CreationTimeUtc`. This timestamp is generated just before sending the request. This will allow the receiver to secure themselves from *Replay*-attacks, for ex. by validating that the `CreationTimeUtc` is below some threshold.
 *
 * The version of the OpenAPI document: v2
 * Generated by: https://openapi-generator.tech
 * Generator version: 7.10.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace OpenAPI\Client\Model;

use \ArrayAccess;
use \OpenAPI\Client\ObjectSerializer;

/**
 * Lock2 Class Doc Comment
 *
 * @category Class
 * @description Lock
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class Lock2 implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Lock2';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'clock_installed' => 'bool',
        'clock_installed_date_utc' => '\DateTime',
        'data_version' => 'int',
        'default_program_station_f_prog_key_id' => 'string',
        'description' => 'string',
        'direction' => 'string',
        'door_thickness' => 'string',
        'door_type' => 'string',
        'ext' => 'int',
        'ext_description' => 'string',
        'extention_piece' => 'string',
        'f_lock_id' => 'string',
        'floor_plan_id' => 'string',
        'floor_plan_point_x' => 'float',
        'floor_plan_point_y' => 'float',
        'handed' => 'string',
        'hw_version' => 'int',
        'key_chamber' => 'string',
        'location_code' => 'string',
        'lock_code' => 'string',
        'lock_framework' => 'string',
        'lock_framework_depth' => 'string',
        'locking_object' => 'string',
        'lock_settings' => 'string',
        'lock_state' => 'int',
        'lock_type' => '\OpenAPI\Client\Model\Lock2LockType',
        'mac' => 'string',
        'manufacturing_info' => 'string',
        'mech_version' => 'int',
        'mounting' => 'string',
        'network_module_device_id' => 'string',
        'other_equipment' => 'string',
        'physical_state' => '\OpenAPI\Client\Model\Lock2PhysicalState',
        'real_estate_id' => 'string',
        'serial_number' => 'int',
        'stamp' => 'string',
        'sw_version' => 'int',
        'zone_id' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'clock_installed' => null,
        'clock_installed_date_utc' => 'date-time',
        'data_version' => 'int32',
        'default_program_station_f_prog_key_id' => 'guid',
        'description' => null,
        'direction' => null,
        'door_thickness' => null,
        'door_type' => null,
        'ext' => null,
        'ext_description' => null,
        'extention_piece' => null,
        'f_lock_id' => 'guid',
        'floor_plan_id' => 'guid',
        'floor_plan_point_x' => 'double',
        'floor_plan_point_y' => 'double',
        'handed' => null,
        'hw_version' => 'int32',
        'key_chamber' => null,
        'location_code' => null,
        'lock_code' => null,
        'lock_framework' => null,
        'lock_framework_depth' => null,
        'locking_object' => null,
        'lock_settings' => null,
        'lock_state' => 'int32',
        'lock_type' => null,
        'mac' => null,
        'manufacturing_info' => null,
        'mech_version' => 'int32',
        'mounting' => null,
        'network_module_device_id' => 'guid',
        'other_equipment' => null,
        'physical_state' => null,
        'real_estate_id' => 'guid',
        'serial_number' => 'int32',
        'stamp' => null,
        'sw_version' => 'int32',
        'zone_id' => 'guid'
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'clock_installed' => false,
        'clock_installed_date_utc' => true,
        'data_version' => false,
        'default_program_station_f_prog_key_id' => true,
        'description' => false,
        'direction' => false,
        'door_thickness' => false,
        'door_type' => false,
        'ext' => false,
        'ext_description' => false,
        'extention_piece' => false,
        'f_lock_id' => false,
        'floor_plan_id' => true,
        'floor_plan_point_x' => false,
        'floor_plan_point_y' => false,
        'handed' => false,
        'hw_version' => false,
        'key_chamber' => false,
        'location_code' => false,
        'lock_code' => false,
        'lock_framework' => false,
        'lock_framework_depth' => false,
        'locking_object' => false,
        'lock_settings' => false,
        'lock_state' => false,
        'lock_type' => false,
        'mac' => false,
        'manufacturing_info' => false,
        'mech_version' => false,
        'mounting' => false,
        'network_module_device_id' => true,
        'other_equipment' => false,
        'physical_state' => false,
        'real_estate_id' => false,
        'serial_number' => false,
        'stamp' => false,
        'sw_version' => false,
        'zone_id' => false
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var boolean[]
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return boolean[]
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Setter - Array of nullable field names deliberately set to null
     *
     * @param boolean[] $openAPINullablesSetToNull
     */
    private function setOpenAPINullablesSetToNull(array $openAPINullablesSetToNull): void
    {
        $this->openAPINullablesSetToNull = $openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'clock_installed' => 'ClockInstalled',
        'clock_installed_date_utc' => 'ClockInstalledDateUtc',
        'data_version' => 'DataVersion',
        'default_program_station_f_prog_key_id' => 'DefaultProgramStationFProgKey_ID',
        'description' => 'Description',
        'direction' => 'Direction',
        'door_thickness' => 'DoorThickness',
        'door_type' => 'DoorType',
        'ext' => 'Ext',
        'ext_description' => 'ExtDescription',
        'extention_piece' => 'ExtentionPiece',
        'f_lock_id' => 'FLock_ID',
        'floor_plan_id' => 'FloorPlan_ID',
        'floor_plan_point_x' => 'FloorPlanPointX',
        'floor_plan_point_y' => 'FloorPlanPointY',
        'handed' => 'Handed',
        'hw_version' => 'HwVersion',
        'key_chamber' => 'KeyChamber',
        'location_code' => 'LocationCode',
        'lock_code' => 'LockCode',
        'lock_framework' => 'LockFramework',
        'lock_framework_depth' => 'LockFrameworkDepth',
        'locking_object' => 'LockingObject',
        'lock_settings' => 'LockSettings',
        'lock_state' => 'LockState',
        'lock_type' => 'LockType',
        'mac' => 'MAC',
        'manufacturing_info' => 'ManufacturingInfo',
        'mech_version' => 'MechVersion',
        'mounting' => 'Mounting',
        'network_module_device_id' => 'NetworkModuleDevice_ID',
        'other_equipment' => 'OtherEquipment',
        'physical_state' => 'PhysicalState',
        'real_estate_id' => 'RealEstate_ID',
        'serial_number' => 'SerialNumber',
        'stamp' => 'Stamp',
        'sw_version' => 'SwVersion',
        'zone_id' => 'Zone_ID'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'clock_installed' => 'setClockInstalled',
        'clock_installed_date_utc' => 'setClockInstalledDateUtc',
        'data_version' => 'setDataVersion',
        'default_program_station_f_prog_key_id' => 'setDefaultProgramStationFProgKeyId',
        'description' => 'setDescription',
        'direction' => 'setDirection',
        'door_thickness' => 'setDoorThickness',
        'door_type' => 'setDoorType',
        'ext' => 'setExt',
        'ext_description' => 'setExtDescription',
        'extention_piece' => 'setExtentionPiece',
        'f_lock_id' => 'setFLockId',
        'floor_plan_id' => 'setFloorPlanId',
        'floor_plan_point_x' => 'setFloorPlanPointX',
        'floor_plan_point_y' => 'setFloorPlanPointY',
        'handed' => 'setHanded',
        'hw_version' => 'setHwVersion',
        'key_chamber' => 'setKeyChamber',
        'location_code' => 'setLocationCode',
        'lock_code' => 'setLockCode',
        'lock_framework' => 'setLockFramework',
        'lock_framework_depth' => 'setLockFrameworkDepth',
        'locking_object' => 'setLockingObject',
        'lock_settings' => 'setLockSettings',
        'lock_state' => 'setLockState',
        'lock_type' => 'setLockType',
        'mac' => 'setMac',
        'manufacturing_info' => 'setManufacturingInfo',
        'mech_version' => 'setMechVersion',
        'mounting' => 'setMounting',
        'network_module_device_id' => 'setNetworkModuleDeviceId',
        'other_equipment' => 'setOtherEquipment',
        'physical_state' => 'setPhysicalState',
        'real_estate_id' => 'setRealEstateId',
        'serial_number' => 'setSerialNumber',
        'stamp' => 'setStamp',
        'sw_version' => 'setSwVersion',
        'zone_id' => 'setZoneId'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'clock_installed' => 'getClockInstalled',
        'clock_installed_date_utc' => 'getClockInstalledDateUtc',
        'data_version' => 'getDataVersion',
        'default_program_station_f_prog_key_id' => 'getDefaultProgramStationFProgKeyId',
        'description' => 'getDescription',
        'direction' => 'getDirection',
        'door_thickness' => 'getDoorThickness',
        'door_type' => 'getDoorType',
        'ext' => 'getExt',
        'ext_description' => 'getExtDescription',
        'extention_piece' => 'getExtentionPiece',
        'f_lock_id' => 'getFLockId',
        'floor_plan_id' => 'getFloorPlanId',
        'floor_plan_point_x' => 'getFloorPlanPointX',
        'floor_plan_point_y' => 'getFloorPlanPointY',
        'handed' => 'getHanded',
        'hw_version' => 'getHwVersion',
        'key_chamber' => 'getKeyChamber',
        'location_code' => 'getLocationCode',
        'lock_code' => 'getLockCode',
        'lock_framework' => 'getLockFramework',
        'lock_framework_depth' => 'getLockFrameworkDepth',
        'locking_object' => 'getLockingObject',
        'lock_settings' => 'getLockSettings',
        'lock_state' => 'getLockState',
        'lock_type' => 'getLockType',
        'mac' => 'getMac',
        'manufacturing_info' => 'getManufacturingInfo',
        'mech_version' => 'getMechVersion',
        'mounting' => 'getMounting',
        'network_module_device_id' => 'getNetworkModuleDeviceId',
        'other_equipment' => 'getOtherEquipment',
        'physical_state' => 'getPhysicalState',
        'real_estate_id' => 'getRealEstateId',
        'serial_number' => 'getSerialNumber',
        'stamp' => 'getStamp',
        'sw_version' => 'getSwVersion',
        'zone_id' => 'getZoneId'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }


    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('clock_installed', $data ?? [], null);
        $this->setIfExists('clock_installed_date_utc', $data ?? [], null);
        $this->setIfExists('data_version', $data ?? [], null);
        $this->setIfExists('default_program_station_f_prog_key_id', $data ?? [], null);
        $this->setIfExists('description', $data ?? [], null);
        $this->setIfExists('direction', $data ?? [], null);
        $this->setIfExists('door_thickness', $data ?? [], null);
        $this->setIfExists('door_type', $data ?? [], null);
        $this->setIfExists('ext', $data ?? [], null);
        $this->setIfExists('ext_description', $data ?? [], null);
        $this->setIfExists('extention_piece', $data ?? [], null);
        $this->setIfExists('f_lock_id', $data ?? [], null);
        $this->setIfExists('floor_plan_id', $data ?? [], null);
        $this->setIfExists('floor_plan_point_x', $data ?? [], null);
        $this->setIfExists('floor_plan_point_y', $data ?? [], null);
        $this->setIfExists('handed', $data ?? [], null);
        $this->setIfExists('hw_version', $data ?? [], null);
        $this->setIfExists('key_chamber', $data ?? [], null);
        $this->setIfExists('location_code', $data ?? [], null);
        $this->setIfExists('lock_code', $data ?? [], null);
        $this->setIfExists('lock_framework', $data ?? [], null);
        $this->setIfExists('lock_framework_depth', $data ?? [], null);
        $this->setIfExists('locking_object', $data ?? [], null);
        $this->setIfExists('lock_settings', $data ?? [], null);
        $this->setIfExists('lock_state', $data ?? [], null);
        $this->setIfExists('lock_type', $data ?? [], null);
        $this->setIfExists('mac', $data ?? [], null);
        $this->setIfExists('manufacturing_info', $data ?? [], null);
        $this->setIfExists('mech_version', $data ?? [], null);
        $this->setIfExists('mounting', $data ?? [], null);
        $this->setIfExists('network_module_device_id', $data ?? [], null);
        $this->setIfExists('other_equipment', $data ?? [], null);
        $this->setIfExists('physical_state', $data ?? [], null);
        $this->setIfExists('real_estate_id', $data ?? [], null);
        $this->setIfExists('serial_number', $data ?? [], null);
        $this->setIfExists('stamp', $data ?? [], null);
        $this->setIfExists('sw_version', $data ?? [], null);
        $this->setIfExists('zone_id', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['description'] === null) {
            $invalidProperties[] = "'description' can't be null";
        }
        if ((mb_strlen($this->container['description']) > 50)) {
            $invalidProperties[] = "invalid value for 'description', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['description']) < 0)) {
            $invalidProperties[] = "invalid value for 'description', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['direction'] === null) {
            $invalidProperties[] = "'direction' can't be null";
        }
        if ((mb_strlen($this->container['direction']) > 50)) {
            $invalidProperties[] = "invalid value for 'direction', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['direction']) < 0)) {
            $invalidProperties[] = "invalid value for 'direction', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['door_thickness'] === null) {
            $invalidProperties[] = "'door_thickness' can't be null";
        }
        if ((mb_strlen($this->container['door_thickness']) > 50)) {
            $invalidProperties[] = "invalid value for 'door_thickness', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['door_thickness']) < 0)) {
            $invalidProperties[] = "invalid value for 'door_thickness', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['door_type'] === null) {
            $invalidProperties[] = "'door_type' can't be null";
        }
        if ((mb_strlen($this->container['door_type']) > 50)) {
            $invalidProperties[] = "invalid value for 'door_type', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['door_type']) < 0)) {
            $invalidProperties[] = "invalid value for 'door_type', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['ext_description'] === null) {
            $invalidProperties[] = "'ext_description' can't be null";
        }
        if ((mb_strlen($this->container['ext_description']) > 50)) {
            $invalidProperties[] = "invalid value for 'ext_description', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['ext_description']) < 0)) {
            $invalidProperties[] = "invalid value for 'ext_description', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['extention_piece'] === null) {
            $invalidProperties[] = "'extention_piece' can't be null";
        }
        if ((mb_strlen($this->container['extention_piece']) > 50)) {
            $invalidProperties[] = "invalid value for 'extention_piece', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['extention_piece']) < 0)) {
            $invalidProperties[] = "invalid value for 'extention_piece', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['handed'] === null) {
            $invalidProperties[] = "'handed' can't be null";
        }
        if ((mb_strlen($this->container['handed']) > 50)) {
            $invalidProperties[] = "invalid value for 'handed', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['handed']) < 0)) {
            $invalidProperties[] = "invalid value for 'handed', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['key_chamber'] === null) {
            $invalidProperties[] = "'key_chamber' can't be null";
        }
        if ((mb_strlen($this->container['key_chamber']) > 50)) {
            $invalidProperties[] = "invalid value for 'key_chamber', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['key_chamber']) < 0)) {
            $invalidProperties[] = "invalid value for 'key_chamber', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['location_code'] === null) {
            $invalidProperties[] = "'location_code' can't be null";
        }
        if ((mb_strlen($this->container['location_code']) > 50)) {
            $invalidProperties[] = "invalid value for 'location_code', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['location_code']) < 0)) {
            $invalidProperties[] = "invalid value for 'location_code', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['lock_code'] === null) {
            $invalidProperties[] = "'lock_code' can't be null";
        }
        if ((mb_strlen($this->container['lock_code']) > 4)) {
            $invalidProperties[] = "invalid value for 'lock_code', the character length must be smaller than or equal to 4.";
        }

        if ((mb_strlen($this->container['lock_code']) < 0)) {
            $invalidProperties[] = "invalid value for 'lock_code', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['lock_framework'] === null) {
            $invalidProperties[] = "'lock_framework' can't be null";
        }
        if ((mb_strlen($this->container['lock_framework']) > 50)) {
            $invalidProperties[] = "invalid value for 'lock_framework', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['lock_framework']) < 0)) {
            $invalidProperties[] = "invalid value for 'lock_framework', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['lock_framework_depth'] === null) {
            $invalidProperties[] = "'lock_framework_depth' can't be null";
        }
        if ((mb_strlen($this->container['lock_framework_depth']) > 50)) {
            $invalidProperties[] = "invalid value for 'lock_framework_depth', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['lock_framework_depth']) < 0)) {
            $invalidProperties[] = "invalid value for 'lock_framework_depth', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['locking_object'] === null) {
            $invalidProperties[] = "'locking_object' can't be null";
        }
        if ((mb_strlen($this->container['locking_object']) > 50)) {
            $invalidProperties[] = "invalid value for 'locking_object', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['locking_object']) < 0)) {
            $invalidProperties[] = "invalid value for 'locking_object', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['lock_settings'] === null) {
            $invalidProperties[] = "'lock_settings' can't be null";
        }
        if ((mb_strlen($this->container['lock_settings']) > 2)) {
            $invalidProperties[] = "invalid value for 'lock_settings', the character length must be smaller than or equal to 2.";
        }

        if ((mb_strlen($this->container['lock_settings']) < 0)) {
            $invalidProperties[] = "invalid value for 'lock_settings', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['mac'] === null) {
            $invalidProperties[] = "'mac' can't be null";
        }
        if ((mb_strlen($this->container['mac']) > 20)) {
            $invalidProperties[] = "invalid value for 'mac', the character length must be smaller than or equal to 20.";
        }

        if ((mb_strlen($this->container['mac']) < 0)) {
            $invalidProperties[] = "invalid value for 'mac', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['manufacturing_info'] === null) {
            $invalidProperties[] = "'manufacturing_info' can't be null";
        }
        if ((mb_strlen($this->container['manufacturing_info']) > 50)) {
            $invalidProperties[] = "invalid value for 'manufacturing_info', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['manufacturing_info']) < 0)) {
            $invalidProperties[] = "invalid value for 'manufacturing_info', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['mounting'] === null) {
            $invalidProperties[] = "'mounting' can't be null";
        }
        if ((mb_strlen($this->container['mounting']) > 50)) {
            $invalidProperties[] = "invalid value for 'mounting', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['mounting']) < 0)) {
            $invalidProperties[] = "invalid value for 'mounting', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['other_equipment'] === null) {
            $invalidProperties[] = "'other_equipment' can't be null";
        }
        if ((mb_strlen($this->container['other_equipment']) > 50)) {
            $invalidProperties[] = "invalid value for 'other_equipment', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['other_equipment']) < 0)) {
            $invalidProperties[] = "invalid value for 'other_equipment', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['real_estate_id'] === null) {
            $invalidProperties[] = "'real_estate_id' can't be null";
        }
        if ((mb_strlen($this->container['real_estate_id']) < 1)) {
            $invalidProperties[] = "invalid value for 'real_estate_id', the character length must be bigger than or equal to 1.";
        }

        if ($this->container['stamp'] === null) {
            $invalidProperties[] = "'stamp' can't be null";
        }
        if ((mb_strlen($this->container['stamp']) > 50)) {
            $invalidProperties[] = "invalid value for 'stamp', the character length must be smaller than or equal to 50.";
        }

        if ((mb_strlen($this->container['stamp']) < 0)) {
            $invalidProperties[] = "invalid value for 'stamp', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['zone_id'] === null) {
            $invalidProperties[] = "'zone_id' can't be null";
        }
        if ((mb_strlen($this->container['zone_id']) < 1)) {
            $invalidProperties[] = "invalid value for 'zone_id', the character length must be bigger than or equal to 1.";
        }

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets clock_installed
     *
     * @return bool|null
     */
    public function getClockInstalled()
    {
        return $this->container['clock_installed'];
    }

    /**
     * Sets clock_installed
     *
     * @param bool|null $clock_installed Is clock installed
     *
     * @return self
     */
    public function setClockInstalled($clock_installed)
    {
        if (is_null($clock_installed)) {
            throw new \InvalidArgumentException('non-nullable clock_installed cannot be null');
        }
        $this->container['clock_installed'] = $clock_installed;

        return $this;
    }

    /**
     * Gets clock_installed_date_utc
     *
     * @return \DateTime|null
     */
    public function getClockInstalledDateUtc()
    {
        return $this->container['clock_installed_date_utc'];
    }

    /**
     * Sets clock_installed_date_utc
     *
     * @param \DateTime|null $clock_installed_date_utc Date when clock was installed
     *
     * @return self
     */
    public function setClockInstalledDateUtc($clock_installed_date_utc)
    {
        if (is_null($clock_installed_date_utc)) {
            array_push($this->openAPINullablesSetToNull, 'clock_installed_date_utc');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('clock_installed_date_utc', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['clock_installed_date_utc'] = $clock_installed_date_utc;

        return $this;
    }

    /**
     * Gets data_version
     *
     * @return int|null
     */
    public function getDataVersion()
    {
        return $this->container['data_version'];
    }

    /**
     * Sets data_version
     *
     * @param int|null $data_version Data version
     *
     * @return self
     */
    public function setDataVersion($data_version)
    {
        if (is_null($data_version)) {
            throw new \InvalidArgumentException('non-nullable data_version cannot be null');
        }
        $this->container['data_version'] = $data_version;

        return $this;
    }

    /**
     * Gets default_program_station_f_prog_key_id
     *
     * @return string|null
     */
    public function getDefaultProgramStationFProgKeyId()
    {
        return $this->container['default_program_station_f_prog_key_id'];
    }

    /**
     * Sets default_program_station_f_prog_key_id
     *
     * @param string|null $default_program_station_f_prog_key_id Default programming station ID
     *
     * @return self
     */
    public function setDefaultProgramStationFProgKeyId($default_program_station_f_prog_key_id)
    {
        if (is_null($default_program_station_f_prog_key_id)) {
            array_push($this->openAPINullablesSetToNull, 'default_program_station_f_prog_key_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('default_program_station_f_prog_key_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['default_program_station_f_prog_key_id'] = $default_program_station_f_prog_key_id;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string $description Description
     *
     * @return self
     */
    public function setDescription($description)
    {
        if (is_null($description)) {
            throw new \InvalidArgumentException('non-nullable description cannot be null');
        }
        if ((mb_strlen($description) > 50)) {
            throw new \InvalidArgumentException('invalid length for $description when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($description) < 0)) {
            throw new \InvalidArgumentException('invalid length for $description when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->container['direction'];
    }

    /**
     * Sets direction
     *
     * @param string $direction Access direction
     *
     * @return self
     */
    public function setDirection($direction)
    {
        if (is_null($direction)) {
            throw new \InvalidArgumentException('non-nullable direction cannot be null');
        }
        if ((mb_strlen($direction) > 50)) {
            throw new \InvalidArgumentException('invalid length for $direction when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($direction) < 0)) {
            throw new \InvalidArgumentException('invalid length for $direction when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['direction'] = $direction;

        return $this;
    }

    /**
     * Gets door_thickness
     *
     * @return string
     */
    public function getDoorThickness()
    {
        return $this->container['door_thickness'];
    }

    /**
     * Sets door_thickness
     *
     * @param string $door_thickness Door thickness
     *
     * @return self
     */
    public function setDoorThickness($door_thickness)
    {
        if (is_null($door_thickness)) {
            throw new \InvalidArgumentException('non-nullable door_thickness cannot be null');
        }
        if ((mb_strlen($door_thickness) > 50)) {
            throw new \InvalidArgumentException('invalid length for $door_thickness when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($door_thickness) < 0)) {
            throw new \InvalidArgumentException('invalid length for $door_thickness when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['door_thickness'] = $door_thickness;

        return $this;
    }

    /**
     * Gets door_type
     *
     * @return string
     */
    public function getDoorType()
    {
        return $this->container['door_type'];
    }

    /**
     * Sets door_type
     *
     * @param string $door_type Door type
     *
     * @return self
     */
    public function setDoorType($door_type)
    {
        if (is_null($door_type)) {
            throw new \InvalidArgumentException('non-nullable door_type cannot be null');
        }
        if ((mb_strlen($door_type) > 50)) {
            throw new \InvalidArgumentException('invalid length for $door_type when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($door_type) < 0)) {
            throw new \InvalidArgumentException('invalid length for $door_type when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['door_type'] = $door_type;

        return $this;
    }

    /**
     * Gets ext
     *
     * @return int|null
     */
    public function getExt()
    {
        return $this->container['ext'];
    }

    /**
     * Sets ext
     *
     * @param int|null $ext Is conditional access
     *
     * @return self
     */
    public function setExt($ext)
    {
        if (is_null($ext)) {
            throw new \InvalidArgumentException('non-nullable ext cannot be null');
        }
        $this->container['ext'] = $ext;

        return $this;
    }

    /**
     * Gets ext_description
     *
     * @return string
     */
    public function getExtDescription()
    {
        return $this->container['ext_description'];
    }

    /**
     * Sets ext_description
     *
     * @param string $ext_description Conditional access description
     *
     * @return self
     */
    public function setExtDescription($ext_description)
    {
        if (is_null($ext_description)) {
            throw new \InvalidArgumentException('non-nullable ext_description cannot be null');
        }
        if ((mb_strlen($ext_description) > 50)) {
            throw new \InvalidArgumentException('invalid length for $ext_description when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($ext_description) < 0)) {
            throw new \InvalidArgumentException('invalid length for $ext_description when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['ext_description'] = $ext_description;

        return $this;
    }

    /**
     * Gets extention_piece
     *
     * @return string
     */
    public function getExtentionPiece()
    {
        return $this->container['extention_piece'];
    }

    /**
     * Sets extention_piece
     *
     * @param string $extention_piece Extention piece
     *
     * @return self
     */
    public function setExtentionPiece($extention_piece)
    {
        if (is_null($extention_piece)) {
            throw new \InvalidArgumentException('non-nullable extention_piece cannot be null');
        }
        if ((mb_strlen($extention_piece) > 50)) {
            throw new \InvalidArgumentException('invalid length for $extention_piece when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($extention_piece) < 0)) {
            throw new \InvalidArgumentException('invalid length for $extention_piece when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['extention_piece'] = $extention_piece;

        return $this;
    }

    /**
     * Gets f_lock_id
     *
     * @return string|null
     */
    public function getFLockId()
    {
        return $this->container['f_lock_id'];
    }

    /**
     * Sets f_lock_id
     *
     * @param string|null $f_lock_id ID
     *
     * @return self
     */
    public function setFLockId($f_lock_id)
    {
        if (is_null($f_lock_id)) {
            throw new \InvalidArgumentException('non-nullable f_lock_id cannot be null');
        }
        $this->container['f_lock_id'] = $f_lock_id;

        return $this;
    }

    /**
     * Gets floor_plan_id
     *
     * @return string|null
     */
    public function getFloorPlanId()
    {
        return $this->container['floor_plan_id'];
    }

    /**
     * Sets floor_plan_id
     *
     * @param string|null $floor_plan_id Floorplan ID if lock is on a floorplan
     *
     * @return self
     */
    public function setFloorPlanId($floor_plan_id)
    {
        if (is_null($floor_plan_id)) {
            array_push($this->openAPINullablesSetToNull, 'floor_plan_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('floor_plan_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['floor_plan_id'] = $floor_plan_id;

        return $this;
    }

    /**
     * Gets floor_plan_point_x
     *
     * @return float|null
     */
    public function getFloorPlanPointX()
    {
        return $this->container['floor_plan_point_x'];
    }

    /**
     * Sets floor_plan_point_x
     *
     * @param float|null $floor_plan_point_x X position on floorplan
     *
     * @return self
     */
    public function setFloorPlanPointX($floor_plan_point_x)
    {
        if (is_null($floor_plan_point_x)) {
            throw new \InvalidArgumentException('non-nullable floor_plan_point_x cannot be null');
        }
        $this->container['floor_plan_point_x'] = $floor_plan_point_x;

        return $this;
    }

    /**
     * Gets floor_plan_point_y
     *
     * @return float|null
     */
    public function getFloorPlanPointY()
    {
        return $this->container['floor_plan_point_y'];
    }

    /**
     * Sets floor_plan_point_y
     *
     * @param float|null $floor_plan_point_y Y position on floorplan
     *
     * @return self
     */
    public function setFloorPlanPointY($floor_plan_point_y)
    {
        if (is_null($floor_plan_point_y)) {
            throw new \InvalidArgumentException('non-nullable floor_plan_point_y cannot be null');
        }
        $this->container['floor_plan_point_y'] = $floor_plan_point_y;

        return $this;
    }

    /**
     * Gets handed
     *
     * @return string
     */
    public function getHanded()
    {
        return $this->container['handed'];
    }

    /**
     * Sets handed
     *
     * @param string $handed Handed
     *
     * @return self
     */
    public function setHanded($handed)
    {
        if (is_null($handed)) {
            throw new \InvalidArgumentException('non-nullable handed cannot be null');
        }
        if ((mb_strlen($handed) > 50)) {
            throw new \InvalidArgumentException('invalid length for $handed when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($handed) < 0)) {
            throw new \InvalidArgumentException('invalid length for $handed when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['handed'] = $handed;

        return $this;
    }

    /**
     * Gets hw_version
     *
     * @return int|null
     */
    public function getHwVersion()
    {
        return $this->container['hw_version'];
    }

    /**
     * Sets hw_version
     *
     * @param int|null $hw_version Hardware version
     *
     * @return self
     */
    public function setHwVersion($hw_version)
    {
        if (is_null($hw_version)) {
            throw new \InvalidArgumentException('non-nullable hw_version cannot be null');
        }
        $this->container['hw_version'] = $hw_version;

        return $this;
    }

    /**
     * Gets key_chamber
     *
     * @return string
     */
    public function getKeyChamber()
    {
        return $this->container['key_chamber'];
    }

    /**
     * Sets key_chamber
     *
     * @param string $key_chamber Keychamber
     *
     * @return self
     */
    public function setKeyChamber($key_chamber)
    {
        if (is_null($key_chamber)) {
            throw new \InvalidArgumentException('non-nullable key_chamber cannot be null');
        }
        if ((mb_strlen($key_chamber) > 50)) {
            throw new \InvalidArgumentException('invalid length for $key_chamber when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($key_chamber) < 0)) {
            throw new \InvalidArgumentException('invalid length for $key_chamber when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['key_chamber'] = $key_chamber;

        return $this;
    }

    /**
     * Gets location_code
     *
     * @return string
     */
    public function getLocationCode()
    {
        return $this->container['location_code'];
    }

    /**
     * Sets location_code
     *
     * @param string $location_code Location code
     *
     * @return self
     */
    public function setLocationCode($location_code)
    {
        if (is_null($location_code)) {
            throw new \InvalidArgumentException('non-nullable location_code cannot be null');
        }
        if ((mb_strlen($location_code) > 50)) {
            throw new \InvalidArgumentException('invalid length for $location_code when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($location_code) < 0)) {
            throw new \InvalidArgumentException('invalid length for $location_code when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['location_code'] = $location_code;

        return $this;
    }

    /**
     * Gets lock_code
     *
     * @return string
     */
    public function getLockCode()
    {
        return $this->container['lock_code'];
    }

    /**
     * Sets lock_code
     *
     * @param string $lock_code Lock code
     *
     * @return self
     */
    public function setLockCode($lock_code)
    {
        if (is_null($lock_code)) {
            throw new \InvalidArgumentException('non-nullable lock_code cannot be null');
        }
        if ((mb_strlen($lock_code) > 4)) {
            throw new \InvalidArgumentException('invalid length for $lock_code when calling Lock2., must be smaller than or equal to 4.');
        }
        if ((mb_strlen($lock_code) < 0)) {
            throw new \InvalidArgumentException('invalid length for $lock_code when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['lock_code'] = $lock_code;

        return $this;
    }

    /**
     * Gets lock_framework
     *
     * @return string
     */
    public function getLockFramework()
    {
        return $this->container['lock_framework'];
    }

    /**
     * Sets lock_framework
     *
     * @param string $lock_framework Framework
     *
     * @return self
     */
    public function setLockFramework($lock_framework)
    {
        if (is_null($lock_framework)) {
            throw new \InvalidArgumentException('non-nullable lock_framework cannot be null');
        }
        if ((mb_strlen($lock_framework) > 50)) {
            throw new \InvalidArgumentException('invalid length for $lock_framework when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($lock_framework) < 0)) {
            throw new \InvalidArgumentException('invalid length for $lock_framework when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['lock_framework'] = $lock_framework;

        return $this;
    }

    /**
     * Gets lock_framework_depth
     *
     * @return string
     */
    public function getLockFrameworkDepth()
    {
        return $this->container['lock_framework_depth'];
    }

    /**
     * Sets lock_framework_depth
     *
     * @param string $lock_framework_depth Framework depth
     *
     * @return self
     */
    public function setLockFrameworkDepth($lock_framework_depth)
    {
        if (is_null($lock_framework_depth)) {
            throw new \InvalidArgumentException('non-nullable lock_framework_depth cannot be null');
        }
        if ((mb_strlen($lock_framework_depth) > 50)) {
            throw new \InvalidArgumentException('invalid length for $lock_framework_depth when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($lock_framework_depth) < 0)) {
            throw new \InvalidArgumentException('invalid length for $lock_framework_depth when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['lock_framework_depth'] = $lock_framework_depth;

        return $this;
    }

    /**
     * Gets locking_object
     *
     * @return string
     */
    public function getLockingObject()
    {
        return $this->container['locking_object'];
    }

    /**
     * Sets locking_object
     *
     * @param string $locking_object Locking object
     *
     * @return self
     */
    public function setLockingObject($locking_object)
    {
        if (is_null($locking_object)) {
            throw new \InvalidArgumentException('non-nullable locking_object cannot be null');
        }
        if ((mb_strlen($locking_object) > 50)) {
            throw new \InvalidArgumentException('invalid length for $locking_object when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($locking_object) < 0)) {
            throw new \InvalidArgumentException('invalid length for $locking_object when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['locking_object'] = $locking_object;

        return $this;
    }

    /**
     * Gets lock_settings
     *
     * @return string
     */
    public function getLockSettings()
    {
        return $this->container['lock_settings'];
    }

    /**
     * Sets lock_settings
     *
     * @param string $lock_settings Settings
     *
     * @return self
     */
    public function setLockSettings($lock_settings)
    {
        if (is_null($lock_settings)) {
            throw new \InvalidArgumentException('non-nullable lock_settings cannot be null');
        }
        if ((mb_strlen($lock_settings) > 2)) {
            throw new \InvalidArgumentException('invalid length for $lock_settings when calling Lock2., must be smaller than or equal to 2.');
        }
        if ((mb_strlen($lock_settings) < 0)) {
            throw new \InvalidArgumentException('invalid length for $lock_settings when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['lock_settings'] = $lock_settings;

        return $this;
    }

    /**
     * Gets lock_state
     *
     * @return int|null
     */
    public function getLockState()
    {
        return $this->container['lock_state'];
    }

    /**
     * Sets lock_state
     *
     * @param int|null $lock_state Lock state from lock's acknowledge packet. Internal use only.
     *
     * @return self
     */
    public function setLockState($lock_state)
    {
        if (is_null($lock_state)) {
            throw new \InvalidArgumentException('non-nullable lock_state cannot be null');
        }
        $this->container['lock_state'] = $lock_state;

        return $this;
    }

    /**
     * Gets lock_type
     *
     * @return \OpenAPI\Client\Model\Lock2LockType|null
     */
    public function getLockType()
    {
        return $this->container['lock_type'];
    }

    /**
     * Sets lock_type
     *
     * @param \OpenAPI\Client\Model\Lock2LockType|null $lock_type lock_type
     *
     * @return self
     */
    public function setLockType($lock_type)
    {
        if (is_null($lock_type)) {
            throw new \InvalidArgumentException('non-nullable lock_type cannot be null');
        }
        $this->container['lock_type'] = $lock_type;

        return $this;
    }

    /**
     * Gets mac
     *
     * @return string
     */
    public function getMac()
    {
        return $this->container['mac'];
    }

    /**
     * Sets mac
     *
     * @param string $mac MAC
     *
     * @return self
     */
    public function setMac($mac)
    {
        if (is_null($mac)) {
            throw new \InvalidArgumentException('non-nullable mac cannot be null');
        }
        if ((mb_strlen($mac) > 20)) {
            throw new \InvalidArgumentException('invalid length for $mac when calling Lock2., must be smaller than or equal to 20.');
        }
        if ((mb_strlen($mac) < 0)) {
            throw new \InvalidArgumentException('invalid length for $mac when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['mac'] = $mac;

        return $this;
    }

    /**
     * Gets manufacturing_info
     *
     * @return string
     */
    public function getManufacturingInfo()
    {
        return $this->container['manufacturing_info'];
    }

    /**
     * Sets manufacturing_info
     *
     * @param string $manufacturing_info Manufacturing info
     *
     * @return self
     */
    public function setManufacturingInfo($manufacturing_info)
    {
        if (is_null($manufacturing_info)) {
            throw new \InvalidArgumentException('non-nullable manufacturing_info cannot be null');
        }
        if ((mb_strlen($manufacturing_info) > 50)) {
            throw new \InvalidArgumentException('invalid length for $manufacturing_info when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($manufacturing_info) < 0)) {
            throw new \InvalidArgumentException('invalid length for $manufacturing_info when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['manufacturing_info'] = $manufacturing_info;

        return $this;
    }

    /**
     * Gets mech_version
     *
     * @return int|null
     */
    public function getMechVersion()
    {
        return $this->container['mech_version'];
    }

    /**
     * Sets mech_version
     *
     * @param int|null $mech_version Mech version
     *
     * @return self
     */
    public function setMechVersion($mech_version)
    {
        if (is_null($mech_version)) {
            throw new \InvalidArgumentException('non-nullable mech_version cannot be null');
        }
        $this->container['mech_version'] = $mech_version;

        return $this;
    }

    /**
     * Gets mounting
     *
     * @return string
     */
    public function getMounting()
    {
        return $this->container['mounting'];
    }

    /**
     * Sets mounting
     *
     * @param string $mounting Mounting
     *
     * @return self
     */
    public function setMounting($mounting)
    {
        if (is_null($mounting)) {
            throw new \InvalidArgumentException('non-nullable mounting cannot be null');
        }
        if ((mb_strlen($mounting) > 50)) {
            throw new \InvalidArgumentException('invalid length for $mounting when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($mounting) < 0)) {
            throw new \InvalidArgumentException('invalid length for $mounting when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['mounting'] = $mounting;

        return $this;
    }

    /**
     * Gets network_module_device_id
     *
     * @return string|null
     */
    public function getNetworkModuleDeviceId()
    {
        return $this->container['network_module_device_id'];
    }

    /**
     * Sets network_module_device_id
     *
     * @param string|null $network_module_device_id Network module device ID
     *
     * @return self
     */
    public function setNetworkModuleDeviceId($network_module_device_id)
    {
        if (is_null($network_module_device_id)) {
            array_push($this->openAPINullablesSetToNull, 'network_module_device_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('network_module_device_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['network_module_device_id'] = $network_module_device_id;

        return $this;
    }

    /**
     * Gets other_equipment
     *
     * @return string
     */
    public function getOtherEquipment()
    {
        return $this->container['other_equipment'];
    }

    /**
     * Sets other_equipment
     *
     * @param string $other_equipment Other equipment
     *
     * @return self
     */
    public function setOtherEquipment($other_equipment)
    {
        if (is_null($other_equipment)) {
            throw new \InvalidArgumentException('non-nullable other_equipment cannot be null');
        }
        if ((mb_strlen($other_equipment) > 50)) {
            throw new \InvalidArgumentException('invalid length for $other_equipment when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($other_equipment) < 0)) {
            throw new \InvalidArgumentException('invalid length for $other_equipment when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['other_equipment'] = $other_equipment;

        return $this;
    }

    /**
     * Gets physical_state
     *
     * @return \OpenAPI\Client\Model\Lock2PhysicalState|null
     */
    public function getPhysicalState()
    {
        return $this->container['physical_state'];
    }

    /**
     * Sets physical_state
     *
     * @param \OpenAPI\Client\Model\Lock2PhysicalState|null $physical_state physical_state
     *
     * @return self
     */
    public function setPhysicalState($physical_state)
    {
        if (is_null($physical_state)) {
            throw new \InvalidArgumentException('non-nullable physical_state cannot be null');
        }
        $this->container['physical_state'] = $physical_state;

        return $this;
    }

    /**
     * Gets real_estate_id
     *
     * @return string
     */
    public function getRealEstateId()
    {
        return $this->container['real_estate_id'];
    }

    /**
     * Sets real_estate_id
     *
     * @param string $real_estate_id Real estate
     *
     * @return self
     */
    public function setRealEstateId($real_estate_id)
    {
        if (is_null($real_estate_id)) {
            throw new \InvalidArgumentException('non-nullable real_estate_id cannot be null');
        }

        if ((mb_strlen($real_estate_id) < 1)) {
            throw new \InvalidArgumentException('invalid length for $real_estate_id when calling Lock2., must be bigger than or equal to 1.');
        }

        $this->container['real_estate_id'] = $real_estate_id;

        return $this;
    }

    /**
     * Gets serial_number
     *
     * @return int|null
     */
    public function getSerialNumber()
    {
        return $this->container['serial_number'];
    }

    /**
     * Sets serial_number
     *
     * @param int|null $serial_number Serial number
     *
     * @return self
     */
    public function setSerialNumber($serial_number)
    {
        if (is_null($serial_number)) {
            throw new \InvalidArgumentException('non-nullable serial_number cannot be null');
        }
        $this->container['serial_number'] = $serial_number;

        return $this;
    }

    /**
     * Gets stamp
     *
     * @return string
     */
    public function getStamp()
    {
        return $this->container['stamp'];
    }

    /**
     * Sets stamp
     *
     * @param string $stamp Stamp
     *
     * @return self
     */
    public function setStamp($stamp)
    {
        if (is_null($stamp)) {
            throw new \InvalidArgumentException('non-nullable stamp cannot be null');
        }
        if ((mb_strlen($stamp) > 50)) {
            throw new \InvalidArgumentException('invalid length for $stamp when calling Lock2., must be smaller than or equal to 50.');
        }
        if ((mb_strlen($stamp) < 0)) {
            throw new \InvalidArgumentException('invalid length for $stamp when calling Lock2., must be bigger than or equal to 0.');
        }

        $this->container['stamp'] = $stamp;

        return $this;
    }

    /**
     * Gets sw_version
     *
     * @return int|null
     */
    public function getSwVersion()
    {
        return $this->container['sw_version'];
    }

    /**
     * Sets sw_version
     *
     * @param int|null $sw_version Software version
     *
     * @return self
     */
    public function setSwVersion($sw_version)
    {
        if (is_null($sw_version)) {
            throw new \InvalidArgumentException('non-nullable sw_version cannot be null');
        }
        $this->container['sw_version'] = $sw_version;

        return $this;
    }

    /**
     * Gets zone_id
     *
     * @return string
     */
    public function getZoneId()
    {
        return $this->container['zone_id'];
    }

    /**
     * Sets zone_id
     *
     * @param string $zone_id Zone
     *
     * @return self
     */
    public function setZoneId($zone_id)
    {
        if (is_null($zone_id)) {
            throw new \InvalidArgumentException('non-nullable zone_id cannot be null');
        }

        if ((mb_strlen($zone_id) < 1)) {
            throw new \InvalidArgumentException('invalid length for $zone_id when calling Lock2., must be bigger than or equal to 1.');
        }

        $this->container['zone_id'] = $zone_id;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


