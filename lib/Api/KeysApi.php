<?php
/**
 * KeysApi
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

namespace OpenAPI\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use OpenAPI\Client\ApiException;
use OpenAPI\Client\Configuration;
use OpenAPI\Client\HeaderSelector;
use OpenAPI\Client\ObjectSerializer;

/**
 * KeysApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class KeysApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /** @var string[] $contentTypes **/
    public const contentTypes = [
        'keysCanAddSecurityAccess' => [
            'application/json',
        ],
        'keysCanAddTimeLimitTitle' => [
            'application/json',
        ],
        'keysCanAddTimeLimitTitleObsolete' => [
            'application/json',
        ],
        'keysCanDeleteKey' => [
            'application/json',
        ],
        'keysCanDeleteSecurityAccess' => [
            'application/json',
        ],
        'keysCanOrderKey' => [
            'application/json',
        ],
        'keysCanReturnKey' => [
            'application/json',
        ],
        'keysCanUpdateKeyMainZone' => [
            'application/json',
        ],
        'keysDelete' => [
            'application/json',
        ],
        'keysDeleteSecurityAccess' => [
            'application/json',
        ],
        'keysDeleteTimeLimit' => [
            'application/json',
        ],
        'keysGetAllKeys' => [
            'application/json',
        ],
        'keysGetKey' => [
            'application/json',
        ],
        'keysGetKeyLocationReportingInAuditTrail' => [
            'application/json',
        ],
        'keysGetKeysByPerson' => [
            'application/json',
        ],
        'keysGetKeysByRomIds' => [
            'application/json',
        ],
        'keysGetSecurityAccesses' => [
            'application/json',
        ],
        'keysGetTimeLimit' => [
            'application/json',
        ],
        'keysGetTimeLimits' => [
            'application/json',
        ],
        'keysGetZones' => [
            'application/json',
        ],
        'keysInsert' => [
            'application/json',
        ],
        'keysInsertSecurityAccess' => [
            'application/json',
        ],
        'keysInsertTimeLimitTitle' => [
            'application/json',
        ],
        'keysOrderKey' => [
            'application/json',
        ],
        'keysReturnKey' => [
            'application/json',
        ],
        'keysSetKeyLocationReportingInAuditTrail' => [
            'application/json',
        ],
        'keysUpdate' => [
            'application/json',
        ],
        'keysUpdateMainZone' => [
            'application/json',
        ],
        'keysUpdateSecurityAccesses' => [
            'application/json',
        ],
        'keysUpdateTimeLimit' => [
            'application/json',
        ],
    ];

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $hostIndex (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $hostIndex = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: Configuration::getDefaultConfiguration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
    }

    /**
     * Set the host index
     *
     * @param int $hostIndex Host index (required)
     */
    public function setHostIndex($hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation keysCanAddSecurityAccess
     *
     * /api/v2/Keys/{id}/SecurityAccesses/CanAdd
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanAddSecurityAccessLink
     */
    public function keysCanAddSecurityAccess($id, string $contentType = self::contentTypes['keysCanAddSecurityAccess'][0])
    {
        list($response) = $this->keysCanAddSecurityAccessWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysCanAddSecurityAccessWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses/CanAdd
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanAddSecurityAccessLink, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysCanAddSecurityAccessWithHttpInfo($id, string $contentType = self::contentTypes['keysCanAddSecurityAccess'][0])
    {
        $request = $this->keysCanAddSecurityAccessRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanAddSecurityAccessLink' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanAddSecurityAccessLink' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanAddSecurityAccessLink', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanAddSecurityAccessLink';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanAddSecurityAccessLink',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanAddSecurityAccessAsync
     *
     * /api/v2/Keys/{id}/SecurityAccesses/CanAdd
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanAddSecurityAccessAsync($id, string $contentType = self::contentTypes['keysCanAddSecurityAccess'][0])
    {
        return $this->keysCanAddSecurityAccessAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanAddSecurityAccessAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses/CanAdd
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanAddSecurityAccessAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysCanAddSecurityAccess'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanAddSecurityAccessLink';
        $request = $this->keysCanAddSecurityAccessRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanAddSecurityAccess'
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysCanAddSecurityAccessRequest($id, string $contentType = self::contentTypes['keysCanAddSecurityAccess'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanAddSecurityAccess'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/SecurityAccesses/CanAdd';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysCanAddTimeLimitTitle
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanAddTimeLimit
     */
    public function keysCanAddTimeLimitTitle($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitle'][0])
    {
        list($response) = $this->keysCanAddTimeLimitTitleWithHttpInfo($id, $insert_key_time_limit_slot_param, $contentType);
        return $response;
    }

    /**
     * Operation keysCanAddTimeLimitTitleWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanAddTimeLimit, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysCanAddTimeLimitTitleWithHttpInfo($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitle'][0])
    {
        $request = $this->keysCanAddTimeLimitTitleRequest($id, $insert_key_time_limit_slot_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanAddTimeLimit' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanAddTimeLimit' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanAddTimeLimit', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanAddTimeLimit';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanAddTimeLimit',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanAddTimeLimitTitleAsync
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanAddTimeLimitTitleAsync($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitle'][0])
    {
        return $this->keysCanAddTimeLimitTitleAsyncWithHttpInfo($id, $insert_key_time_limit_slot_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanAddTimeLimitTitleAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanAddTimeLimitTitleAsyncWithHttpInfo($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitle'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanAddTimeLimit';
        $request = $this->keysCanAddTimeLimitTitleRequest($id, $insert_key_time_limit_slot_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanAddTimeLimitTitle'
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysCanAddTimeLimitTitleRequest($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitle'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanAddTimeLimitTitle'
            );
        }

        // verify the required parameter 'insert_key_time_limit_slot_param' is set
        if ($insert_key_time_limit_slot_param === null || (is_array($insert_key_time_limit_slot_param) && count($insert_key_time_limit_slot_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $insert_key_time_limit_slot_param when calling keysCanAddTimeLimitTitle'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/TimeLimitTitles/CanAdd';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($insert_key_time_limit_slot_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($insert_key_time_limit_slot_param));
            } else {
                $httpBody = $insert_key_time_limit_slot_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysCanAddTimeLimitTitleObsolete
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitleObsolete'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanAddTimeLimit
     * @deprecated
     */
    public function keysCanAddTimeLimitTitleObsolete($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitleObsolete'][0])
    {
        list($response) = $this->keysCanAddTimeLimitTitleObsoleteWithHttpInfo($id, $insert_key_time_limit_slot_param, $contentType);
        return $response;
    }

    /**
     * Operation keysCanAddTimeLimitTitleObsoleteWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitleObsolete'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanAddTimeLimit, HTTP status code, HTTP response headers (array of strings)
     * @deprecated
     */
    public function keysCanAddTimeLimitTitleObsoleteWithHttpInfo($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitleObsolete'][0])
    {
        $request = $this->keysCanAddTimeLimitTitleObsoleteRequest($id, $insert_key_time_limit_slot_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanAddTimeLimit' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanAddTimeLimit' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanAddTimeLimit', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanAddTimeLimit';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanAddTimeLimit',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanAddTimeLimitTitleObsoleteAsync
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitleObsolete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @deprecated
     */
    public function keysCanAddTimeLimitTitleObsoleteAsync($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitleObsolete'][0])
    {
        return $this->keysCanAddTimeLimitTitleObsoleteAsyncWithHttpInfo($id, $insert_key_time_limit_slot_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanAddTimeLimitTitleObsoleteAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/CanAdd
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitleObsolete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @deprecated
     */
    public function keysCanAddTimeLimitTitleObsoleteAsyncWithHttpInfo($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitleObsolete'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanAddTimeLimit';
        $request = $this->keysCanAddTimeLimitTitleObsoleteRequest($id, $insert_key_time_limit_slot_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanAddTimeLimitTitleObsolete'
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanAddTimeLimitTitleObsolete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     * @deprecated
     */
    public function keysCanAddTimeLimitTitleObsoleteRequest($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysCanAddTimeLimitTitleObsolete'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanAddTimeLimitTitleObsolete'
            );
        }

        // verify the required parameter 'insert_key_time_limit_slot_param' is set
        if ($insert_key_time_limit_slot_param === null || (is_array($insert_key_time_limit_slot_param) && count($insert_key_time_limit_slot_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $insert_key_time_limit_slot_param when calling keysCanAddTimeLimitTitleObsolete'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/TimeLimitTitles/CanAdd';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($insert_key_time_limit_slot_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($insert_key_time_limit_slot_param));
            } else {
                $httpBody = $insert_key_time_limit_slot_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysCanDeleteKey
     *
     * /api/v2/Keys/{id}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanDeleteKeyResult
     */
    public function keysCanDeleteKey($id, string $contentType = self::contentTypes['keysCanDeleteKey'][0])
    {
        list($response) = $this->keysCanDeleteKeyWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysCanDeleteKeyWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanDeleteKeyResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysCanDeleteKeyWithHttpInfo($id, string $contentType = self::contentTypes['keysCanDeleteKey'][0])
    {
        $request = $this->keysCanDeleteKeyRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanDeleteKeyResult' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanDeleteKeyResult' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanDeleteKeyResult', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanDeleteKeyResult';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanDeleteKeyResult',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanDeleteKeyAsync
     *
     * /api/v2/Keys/{id}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanDeleteKeyAsync($id, string $contentType = self::contentTypes['keysCanDeleteKey'][0])
    {
        return $this->keysCanDeleteKeyAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanDeleteKeyAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanDeleteKeyAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysCanDeleteKey'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanDeleteKeyResult';
        $request = $this->keysCanDeleteKeyRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanDeleteKey'
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysCanDeleteKeyRequest($id, string $contentType = self::contentTypes['keysCanDeleteKey'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanDeleteKey'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/CanDelete';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysCanDeleteSecurityAccess
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanDeleteSecurityAccessLink
     */
    public function keysCanDeleteSecurityAccess($id, $security_access_id, string $contentType = self::contentTypes['keysCanDeleteSecurityAccess'][0])
    {
        list($response) = $this->keysCanDeleteSecurityAccessWithHttpInfo($id, $security_access_id, $contentType);
        return $response;
    }

    /**
     * Operation keysCanDeleteSecurityAccessWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanDeleteSecurityAccessLink, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysCanDeleteSecurityAccessWithHttpInfo($id, $security_access_id, string $contentType = self::contentTypes['keysCanDeleteSecurityAccess'][0])
    {
        $request = $this->keysCanDeleteSecurityAccessRequest($id, $security_access_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanDeleteSecurityAccessLink' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanDeleteSecurityAccessLink' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanDeleteSecurityAccessLink', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanDeleteSecurityAccessLink';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanDeleteSecurityAccessLink',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanDeleteSecurityAccessAsync
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanDeleteSecurityAccessAsync($id, $security_access_id, string $contentType = self::contentTypes['keysCanDeleteSecurityAccess'][0])
    {
        return $this->keysCanDeleteSecurityAccessAsyncWithHttpInfo($id, $security_access_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanDeleteSecurityAccessAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanDeleteSecurityAccessAsyncWithHttpInfo($id, $security_access_id, string $contentType = self::contentTypes['keysCanDeleteSecurityAccess'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanDeleteSecurityAccessLink';
        $request = $this->keysCanDeleteSecurityAccessRequest($id, $security_access_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanDeleteSecurityAccess'
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysCanDeleteSecurityAccessRequest($id, $security_access_id, string $contentType = self::contentTypes['keysCanDeleteSecurityAccess'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanDeleteSecurityAccess'
            );
        }

        // verify the required parameter 'security_access_id' is set
        if ($security_access_id === null || (is_array($security_access_id) && count($security_access_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $security_access_id when calling keysCanDeleteSecurityAccess'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}/CanDelete';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }
        // path params
        if ($security_access_id !== null) {
            $resourcePath = str_replace(
                '{' . 'securityAccessId' . '}',
                ObjectSerializer::toPathValue($security_access_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysCanOrderKey
     *
     * /api/v2/Keys/{id}/CanOrder
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanOrderKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanOrderKeyResultType
     */
    public function keysCanOrderKey($id, string $contentType = self::contentTypes['keysCanOrderKey'][0])
    {
        list($response) = $this->keysCanOrderKeyWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysCanOrderKeyWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanOrder
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanOrderKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanOrderKeyResultType, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysCanOrderKeyWithHttpInfo($id, string $contentType = self::contentTypes['keysCanOrderKey'][0])
    {
        $request = $this->keysCanOrderKeyRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanOrderKeyResultType' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanOrderKeyResultType' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanOrderKeyResultType', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanOrderKeyResultType';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanOrderKeyResultType',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanOrderKeyAsync
     *
     * /api/v2/Keys/{id}/CanOrder
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanOrderKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanOrderKeyAsync($id, string $contentType = self::contentTypes['keysCanOrderKey'][0])
    {
        return $this->keysCanOrderKeyAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanOrderKeyAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanOrder
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanOrderKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanOrderKeyAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysCanOrderKey'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanOrderKeyResultType';
        $request = $this->keysCanOrderKeyRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanOrderKey'
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanOrderKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysCanOrderKeyRequest($id, string $contentType = self::contentTypes['keysCanOrderKey'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanOrderKey'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/CanOrder';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysCanReturnKey
     *
     * /api/v2/Keys/{id}/CanReturn
     *
     * @param  string $id id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanReturnKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanReturnKeyResultType
     */
    public function keysCanReturnKey($id, string $contentType = self::contentTypes['keysCanReturnKey'][0])
    {
        list($response) = $this->keysCanReturnKeyWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysCanReturnKeyWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanReturn
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanReturnKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanReturnKeyResultType, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysCanReturnKeyWithHttpInfo($id, string $contentType = self::contentTypes['keysCanReturnKey'][0])
    {
        $request = $this->keysCanReturnKeyRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanReturnKeyResultType' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanReturnKeyResultType' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanReturnKeyResultType', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanReturnKeyResultType';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanReturnKeyResultType',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanReturnKeyAsync
     *
     * /api/v2/Keys/{id}/CanReturn
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanReturnKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanReturnKeyAsync($id, string $contentType = self::contentTypes['keysCanReturnKey'][0])
    {
        return $this->keysCanReturnKeyAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanReturnKeyAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanReturn
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanReturnKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanReturnKeyAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysCanReturnKey'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanReturnKeyResultType';
        $request = $this->keysCanReturnKeyRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanReturnKey'
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanReturnKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysCanReturnKeyRequest($id, string $contentType = self::contentTypes['keysCanReturnKey'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanReturnKey'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/CanReturn';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysCanUpdateKeyMainZone
     *
     * /api/v2/Keys/{id}/CanUpdateMainZone
     *
     * @param  string $id id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanUpdateKeyMainZone'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\CanUpdateKeyMainZoneResult
     */
    public function keysCanUpdateKeyMainZone($id, string $contentType = self::contentTypes['keysCanUpdateKeyMainZone'][0])
    {
        list($response) = $this->keysCanUpdateKeyMainZoneWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysCanUpdateKeyMainZoneWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanUpdateMainZone
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanUpdateKeyMainZone'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\CanUpdateKeyMainZoneResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysCanUpdateKeyMainZoneWithHttpInfo($id, string $contentType = self::contentTypes['keysCanUpdateKeyMainZone'][0])
    {
        $request = $this->keysCanUpdateKeyMainZoneRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\CanUpdateKeyMainZoneResult' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\CanUpdateKeyMainZoneResult' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\CanUpdateKeyMainZoneResult', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\CanUpdateKeyMainZoneResult';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\CanUpdateKeyMainZoneResult',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysCanUpdateKeyMainZoneAsync
     *
     * /api/v2/Keys/{id}/CanUpdateMainZone
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanUpdateKeyMainZone'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanUpdateKeyMainZoneAsync($id, string $contentType = self::contentTypes['keysCanUpdateKeyMainZone'][0])
    {
        return $this->keysCanUpdateKeyMainZoneAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysCanUpdateKeyMainZoneAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/CanUpdateMainZone
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanUpdateKeyMainZone'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysCanUpdateKeyMainZoneAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysCanUpdateKeyMainZone'][0])
    {
        $returnType = '\OpenAPI\Client\Model\CanUpdateKeyMainZoneResult';
        $request = $this->keysCanUpdateKeyMainZoneRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysCanUpdateKeyMainZone'
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysCanUpdateKeyMainZone'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysCanUpdateKeyMainZoneRequest($id, string $contentType = self::contentTypes['keysCanUpdateKeyMainZone'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysCanUpdateKeyMainZone'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/CanUpdateMainZone';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysDelete
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id to delete (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDelete'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysDelete($id, string $contentType = self::contentTypes['keysDelete'][0])
    {
        $this->keysDeleteWithHttpInfo($id, $contentType);
    }

    /**
     * Operation keysDeleteWithHttpInfo
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id to delete (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDelete'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysDeleteWithHttpInfo($id, string $contentType = self::contentTypes['keysDelete'][0])
    {
        $request = $this->keysDeleteRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysDeleteAsync
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id to delete (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysDeleteAsync($id, string $contentType = self::contentTypes['keysDelete'][0])
    {
        return $this->keysDeleteAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysDeleteAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id to delete (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysDeleteAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysDelete'][0])
    {
        $returnType = '';
        $request = $this->keysDeleteRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysDelete'
     *
     * @param  string $id Key id to delete (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysDeleteRequest($id, string $contentType = self::contentTypes['keysDelete'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysDelete'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'DELETE',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysDeleteSecurityAccess
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access&#39;s id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysDeleteSecurityAccess($id, $security_access_id, string $contentType = self::contentTypes['keysDeleteSecurityAccess'][0])
    {
        $this->keysDeleteSecurityAccessWithHttpInfo($id, $security_access_id, $contentType);
    }

    /**
     * Operation keysDeleteSecurityAccessWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access&#39;s id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysDeleteSecurityAccessWithHttpInfo($id, $security_access_id, string $contentType = self::contentTypes['keysDeleteSecurityAccess'][0])
    {
        $request = $this->keysDeleteSecurityAccessRequest($id, $security_access_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysDeleteSecurityAccessAsync
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access&#39;s id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysDeleteSecurityAccessAsync($id, $security_access_id, string $contentType = self::contentTypes['keysDeleteSecurityAccess'][0])
    {
        return $this->keysDeleteSecurityAccessAsyncWithHttpInfo($id, $security_access_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysDeleteSecurityAccessAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access&#39;s id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysDeleteSecurityAccessAsyncWithHttpInfo($id, $security_access_id, string $contentType = self::contentTypes['keysDeleteSecurityAccess'][0])
    {
        $returnType = '';
        $request = $this->keysDeleteSecurityAccessRequest($id, $security_access_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysDeleteSecurityAccess'
     *
     * @param  string $id Key id (required)
     * @param  string $security_access_id Security access&#39;s id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysDeleteSecurityAccessRequest($id, $security_access_id, string $contentType = self::contentTypes['keysDeleteSecurityAccess'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysDeleteSecurityAccess'
            );
        }

        // verify the required parameter 'security_access_id' is set
        if ($security_access_id === null || (is_array($security_access_id) && count($security_access_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $security_access_id when calling keysDeleteSecurityAccess'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/SecurityAccesses/{securityAccessId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }
        // path params
        if ($security_access_id !== null) {
            $resourcePath = str_replace(
                '{' . 'securityAccessId' . '}',
                ObjectSerializer::toPathValue($security_access_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'DELETE',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysDeleteTimeLimit
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit to be deleted (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteTimeLimit'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysDeleteTimeLimit($id, $time_limit_title_id, string $contentType = self::contentTypes['keysDeleteTimeLimit'][0])
    {
        $this->keysDeleteTimeLimitWithHttpInfo($id, $time_limit_title_id, $contentType);
    }

    /**
     * Operation keysDeleteTimeLimitWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit to be deleted (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteTimeLimit'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysDeleteTimeLimitWithHttpInfo($id, $time_limit_title_id, string $contentType = self::contentTypes['keysDeleteTimeLimit'][0])
    {
        $request = $this->keysDeleteTimeLimitRequest($id, $time_limit_title_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysDeleteTimeLimitAsync
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit to be deleted (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysDeleteTimeLimitAsync($id, $time_limit_title_id, string $contentType = self::contentTypes['keysDeleteTimeLimit'][0])
    {
        return $this->keysDeleteTimeLimitAsyncWithHttpInfo($id, $time_limit_title_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysDeleteTimeLimitAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit to be deleted (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysDeleteTimeLimitAsyncWithHttpInfo($id, $time_limit_title_id, string $contentType = self::contentTypes['keysDeleteTimeLimit'][0])
    {
        $returnType = '';
        $request = $this->keysDeleteTimeLimitRequest($id, $time_limit_title_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysDeleteTimeLimit'
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit to be deleted (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysDeleteTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysDeleteTimeLimitRequest($id, $time_limit_title_id, string $contentType = self::contentTypes['keysDeleteTimeLimit'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysDeleteTimeLimit'
            );
        }

        // verify the required parameter 'time_limit_title_id' is set
        if ($time_limit_title_id === null || (is_array($time_limit_title_id) && count($time_limit_title_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $time_limit_title_id when calling keysDeleteTimeLimit'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }
        // path params
        if ($time_limit_title_id !== null) {
            $resourcePath = str_replace(
                '{' . 'timeLimitTitleId' . '}',
                ObjectSerializer::toPathValue($time_limit_title_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'DELETE',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetAllKeys
     *
     * /api/v2/Keys
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetAllKeys'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\Key[]
     */
    public function keysGetAllKeys(string $contentType = self::contentTypes['keysGetAllKeys'][0])
    {
        list($response) = $this->keysGetAllKeysWithHttpInfo($contentType);
        return $response;
    }

    /**
     * Operation keysGetAllKeysWithHttpInfo
     *
     * /api/v2/Keys
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetAllKeys'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\Key[], HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetAllKeysWithHttpInfo(string $contentType = self::contentTypes['keysGetAllKeys'][0])
    {
        $request = $this->keysGetAllKeysRequest($contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\Key[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\Key[]' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\Key[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\Key[]';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\Key[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetAllKeysAsync
     *
     * /api/v2/Keys
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetAllKeys'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetAllKeysAsync(string $contentType = self::contentTypes['keysGetAllKeys'][0])
    {
        return $this->keysGetAllKeysAsyncWithHttpInfo($contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetAllKeysAsyncWithHttpInfo
     *
     * /api/v2/Keys
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetAllKeys'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetAllKeysAsyncWithHttpInfo(string $contentType = self::contentTypes['keysGetAllKeys'][0])
    {
        $returnType = '\OpenAPI\Client\Model\Key[]';
        $request = $this->keysGetAllKeysRequest($contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetAllKeys'
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetAllKeys'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetAllKeysRequest(string $contentType = self::contentTypes['keysGetAllKeys'][0])
    {


        $resourcePath = '/api/v2/Keys';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;





        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetKey
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\Key
     */
    public function keysGetKey($id, string $contentType = self::contentTypes['keysGetKey'][0])
    {
        list($response) = $this->keysGetKeyWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysGetKeyWithHttpInfo
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\Key, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetKeyWithHttpInfo($id, string $contentType = self::contentTypes['keysGetKey'][0])
    {
        $request = $this->keysGetKeyRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\Key' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\Key' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\Key', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\Key';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\Key',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetKeyAsync
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeyAsync($id, string $contentType = self::contentTypes['keysGetKey'][0])
    {
        return $this->keysGetKeyAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetKeyAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeyAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysGetKey'][0])
    {
        $returnType = '\OpenAPI\Client\Model\Key';
        $request = $this->keysGetKeyRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetKey'
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetKeyRequest($id, string $contentType = self::contentTypes['keysGetKey'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysGetKey'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetKeyLocationReportingInAuditTrail
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult
     */
    public function keysGetKeyLocationReportingInAuditTrail($id, string $contentType = self::contentTypes['keysGetKeyLocationReportingInAuditTrail'][0])
    {
        list($response) = $this->keysGetKeyLocationReportingInAuditTrailWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysGetKeyLocationReportingInAuditTrailWithHttpInfo
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetKeyLocationReportingInAuditTrailWithHttpInfo($id, string $contentType = self::contentTypes['keysGetKeyLocationReportingInAuditTrail'][0])
    {
        $request = $this->keysGetKeyLocationReportingInAuditTrailRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetKeyLocationReportingInAuditTrailAsync
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeyLocationReportingInAuditTrailAsync($id, string $contentType = self::contentTypes['keysGetKeyLocationReportingInAuditTrail'][0])
    {
        return $this->keysGetKeyLocationReportingInAuditTrailAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetKeyLocationReportingInAuditTrailAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeyLocationReportingInAuditTrailAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysGetKeyLocationReportingInAuditTrail'][0])
    {
        $returnType = '\OpenAPI\Client\Model\PublicApiGetKeyLocationReportingInAuditTrailQueryResult';
        $request = $this->keysGetKeyLocationReportingInAuditTrailRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetKeyLocationReportingInAuditTrail'
     *
     * @param  string $id Key id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetKeyLocationReportingInAuditTrailRequest($id, string $contentType = self::contentTypes['keysGetKeyLocationReportingInAuditTrail'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysGetKeyLocationReportingInAuditTrail'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/LocationReporting';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetKeysByPerson
     *
     * /api/v2/Persons/{id}/Keys
     *
     * @param  string $id Person id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByPerson'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\GetKeysByPersonResult
     */
    public function keysGetKeysByPerson($id, string $contentType = self::contentTypes['keysGetKeysByPerson'][0])
    {
        list($response) = $this->keysGetKeysByPersonWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysGetKeysByPersonWithHttpInfo
     *
     * /api/v2/Persons/{id}/Keys
     *
     * @param  string $id Person id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByPerson'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\GetKeysByPersonResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetKeysByPersonWithHttpInfo($id, string $contentType = self::contentTypes['keysGetKeysByPerson'][0])
    {
        $request = $this->keysGetKeysByPersonRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\GetKeysByPersonResult' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\GetKeysByPersonResult' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\GetKeysByPersonResult', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\GetKeysByPersonResult';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\GetKeysByPersonResult',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetKeysByPersonAsync
     *
     * /api/v2/Persons/{id}/Keys
     *
     * @param  string $id Person id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByPerson'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeysByPersonAsync($id, string $contentType = self::contentTypes['keysGetKeysByPerson'][0])
    {
        return $this->keysGetKeysByPersonAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetKeysByPersonAsyncWithHttpInfo
     *
     * /api/v2/Persons/{id}/Keys
     *
     * @param  string $id Person id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByPerson'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeysByPersonAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysGetKeysByPerson'][0])
    {
        $returnType = '\OpenAPI\Client\Model\GetKeysByPersonResult';
        $request = $this->keysGetKeysByPersonRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetKeysByPerson'
     *
     * @param  string $id Person id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByPerson'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetKeysByPersonRequest($id, string $contentType = self::contentTypes['keysGetKeysByPerson'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysGetKeysByPerson'
            );
        }


        $resourcePath = '/api/v2/Persons/{id}/Keys';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetKeysByRomIds
     *
     * /api/v2/Keys/GetByRomIds
     *
     * @param  string[] $rom_ids Rom ids (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByRomIds'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\Key[]
     */
    public function keysGetKeysByRomIds($rom_ids = null, string $contentType = self::contentTypes['keysGetKeysByRomIds'][0])
    {
        list($response) = $this->keysGetKeysByRomIdsWithHttpInfo($rom_ids, $contentType);
        return $response;
    }

    /**
     * Operation keysGetKeysByRomIdsWithHttpInfo
     *
     * /api/v2/Keys/GetByRomIds
     *
     * @param  string[] $rom_ids Rom ids (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByRomIds'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\Key[], HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetKeysByRomIdsWithHttpInfo($rom_ids = null, string $contentType = self::contentTypes['keysGetKeysByRomIds'][0])
    {
        $request = $this->keysGetKeysByRomIdsRequest($rom_ids, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\Key[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\Key[]' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\Key[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\Key[]';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\Key[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetKeysByRomIdsAsync
     *
     * /api/v2/Keys/GetByRomIds
     *
     * @param  string[] $rom_ids Rom ids (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByRomIds'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeysByRomIdsAsync($rom_ids = null, string $contentType = self::contentTypes['keysGetKeysByRomIds'][0])
    {
        return $this->keysGetKeysByRomIdsAsyncWithHttpInfo($rom_ids, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetKeysByRomIdsAsyncWithHttpInfo
     *
     * /api/v2/Keys/GetByRomIds
     *
     * @param  string[] $rom_ids Rom ids (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByRomIds'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetKeysByRomIdsAsyncWithHttpInfo($rom_ids = null, string $contentType = self::contentTypes['keysGetKeysByRomIds'][0])
    {
        $returnType = '\OpenAPI\Client\Model\Key[]';
        $request = $this->keysGetKeysByRomIdsRequest($rom_ids, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetKeysByRomIds'
     *
     * @param  string[] $rom_ids Rom ids (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetKeysByRomIds'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetKeysByRomIdsRequest($rom_ids = null, string $contentType = self::contentTypes['keysGetKeysByRomIds'][0])
    {



        $resourcePath = '/api/v2/Keys/GetByRomIds';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $rom_ids,
            'romIds', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);




        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetSecurityAccesses
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\GetSecurityAccessesView $mode mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\GetKeySecurityAccessesResult
     */
    public function keysGetSecurityAccesses($id, $mode, string $contentType = self::contentTypes['keysGetSecurityAccesses'][0])
    {
        list($response) = $this->keysGetSecurityAccessesWithHttpInfo($id, $mode, $contentType);
        return $response;
    }

    /**
     * Operation keysGetSecurityAccessesWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\GetSecurityAccessesView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\GetKeySecurityAccessesResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetSecurityAccessesWithHttpInfo($id, $mode, string $contentType = self::contentTypes['keysGetSecurityAccesses'][0])
    {
        $request = $this->keysGetSecurityAccessesRequest($id, $mode, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\GetKeySecurityAccessesResult' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\GetKeySecurityAccessesResult' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\GetKeySecurityAccessesResult', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\GetKeySecurityAccessesResult';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\GetKeySecurityAccessesResult',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetSecurityAccessesAsync
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\GetSecurityAccessesView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetSecurityAccessesAsync($id, $mode, string $contentType = self::contentTypes['keysGetSecurityAccesses'][0])
    {
        return $this->keysGetSecurityAccessesAsyncWithHttpInfo($id, $mode, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetSecurityAccessesAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\GetSecurityAccessesView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetSecurityAccessesAsyncWithHttpInfo($id, $mode, string $contentType = self::contentTypes['keysGetSecurityAccesses'][0])
    {
        $returnType = '\OpenAPI\Client\Model\GetKeySecurityAccessesResult';
        $request = $this->keysGetSecurityAccessesRequest($id, $mode, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetSecurityAccesses'
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\GetSecurityAccessesView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetSecurityAccessesRequest($id, $mode, string $contentType = self::contentTypes['keysGetSecurityAccesses'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysGetSecurityAccesses'
            );
        }

        // verify the required parameter 'mode' is set
        if ($mode === null || (is_array($mode) && count($mode) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $mode when calling keysGetSecurityAccesses'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/SecurityAccesses';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $mode,
            'mode', // param base name
            'GetSecurityAccessesView', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);


        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetTimeLimit
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimit'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\KeyTimeLimitSlot
     */
    public function keysGetTimeLimit($id, $time_limit_title_id, string $contentType = self::contentTypes['keysGetTimeLimit'][0])
    {
        list($response) = $this->keysGetTimeLimitWithHttpInfo($id, $time_limit_title_id, $contentType);
        return $response;
    }

    /**
     * Operation keysGetTimeLimitWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimit'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\KeyTimeLimitSlot, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetTimeLimitWithHttpInfo($id, $time_limit_title_id, string $contentType = self::contentTypes['keysGetTimeLimit'][0])
    {
        $request = $this->keysGetTimeLimitRequest($id, $time_limit_title_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\KeyTimeLimitSlot' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\KeyTimeLimitSlot' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\KeyTimeLimitSlot', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\KeyTimeLimitSlot';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\KeyTimeLimitSlot',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetTimeLimitAsync
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetTimeLimitAsync($id, $time_limit_title_id, string $contentType = self::contentTypes['keysGetTimeLimit'][0])
    {
        return $this->keysGetTimeLimitAsyncWithHttpInfo($id, $time_limit_title_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetTimeLimitAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetTimeLimitAsyncWithHttpInfo($id, $time_limit_title_id, string $contentType = self::contentTypes['keysGetTimeLimit'][0])
    {
        $returnType = '\OpenAPI\Client\Model\KeyTimeLimitSlot';
        $request = $this->keysGetTimeLimitRequest($id, $time_limit_title_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetTimeLimit'
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetTimeLimitRequest($id, $time_limit_title_id, string $contentType = self::contentTypes['keysGetTimeLimit'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysGetTimeLimit'
            );
        }

        // verify the required parameter 'time_limit_title_id' is set
        if ($time_limit_title_id === null || (is_array($time_limit_title_id) && count($time_limit_title_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $time_limit_title_id when calling keysGetTimeLimit'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }
        // path params
        if ($time_limit_title_id !== null) {
            $resourcePath = str_replace(
                '{' . 'timeLimitTitleId' . '}',
                ObjectSerializer::toPathValue($time_limit_title_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetTimeLimits
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id Key Id (required)
     * @param  \OpenAPI\Client\Model\GetTimeLimitsView $mode mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimits'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\GetTimeLimitsResult
     */
    public function keysGetTimeLimits($id, $mode, string $contentType = self::contentTypes['keysGetTimeLimits'][0])
    {
        list($response) = $this->keysGetTimeLimitsWithHttpInfo($id, $mode, $contentType);
        return $response;
    }

    /**
     * Operation keysGetTimeLimitsWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id Key Id (required)
     * @param  \OpenAPI\Client\Model\GetTimeLimitsView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimits'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\GetTimeLimitsResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetTimeLimitsWithHttpInfo($id, $mode, string $contentType = self::contentTypes['keysGetTimeLimits'][0])
    {
        $request = $this->keysGetTimeLimitsRequest($id, $mode, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\GetTimeLimitsResult' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\GetTimeLimitsResult' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\GetTimeLimitsResult', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\GetTimeLimitsResult';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\GetTimeLimitsResult',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetTimeLimitsAsync
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id Key Id (required)
     * @param  \OpenAPI\Client\Model\GetTimeLimitsView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimits'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetTimeLimitsAsync($id, $mode, string $contentType = self::contentTypes['keysGetTimeLimits'][0])
    {
        return $this->keysGetTimeLimitsAsyncWithHttpInfo($id, $mode, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetTimeLimitsAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id Key Id (required)
     * @param  \OpenAPI\Client\Model\GetTimeLimitsView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimits'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetTimeLimitsAsyncWithHttpInfo($id, $mode, string $contentType = self::contentTypes['keysGetTimeLimits'][0])
    {
        $returnType = '\OpenAPI\Client\Model\GetTimeLimitsResult';
        $request = $this->keysGetTimeLimitsRequest($id, $mode, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetTimeLimits'
     *
     * @param  string $id Key Id (required)
     * @param  \OpenAPI\Client\Model\GetTimeLimitsView $mode (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetTimeLimits'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetTimeLimitsRequest($id, $mode, string $contentType = self::contentTypes['keysGetTimeLimits'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysGetTimeLimits'
            );
        }

        // verify the required parameter 'mode' is set
        if ($mode === null || (is_array($mode) && count($mode) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $mode when calling keysGetTimeLimits'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/TimeLimitTitles';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $mode,
            'mode', // param base name
            'GetTimeLimitsView', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);


        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysGetZones
     *
     * /api/v2/Keys/{id}/Zones
     *
     * @param  string $id id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetZones'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\GetZonesResult
     */
    public function keysGetZones($id, string $contentType = self::contentTypes['keysGetZones'][0])
    {
        list($response) = $this->keysGetZonesWithHttpInfo($id, $contentType);
        return $response;
    }

    /**
     * Operation keysGetZonesWithHttpInfo
     *
     * /api/v2/Keys/{id}/Zones
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetZones'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\GetZonesResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysGetZonesWithHttpInfo($id, string $contentType = self::contentTypes['keysGetZones'][0])
    {
        $request = $this->keysGetZonesRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\GetZonesResult' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\GetZonesResult' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\GetZonesResult', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\GetZonesResult';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\GetZonesResult',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysGetZonesAsync
     *
     * /api/v2/Keys/{id}/Zones
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetZones'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetZonesAsync($id, string $contentType = self::contentTypes['keysGetZones'][0])
    {
        return $this->keysGetZonesAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysGetZonesAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/Zones
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetZones'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysGetZonesAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysGetZones'][0])
    {
        $returnType = '\OpenAPI\Client\Model\GetZonesResult';
        $request = $this->keysGetZonesRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysGetZones'
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysGetZones'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysGetZonesRequest($id, string $contentType = self::contentTypes['keysGetZones'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysGetZones'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/Zones';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysInsert
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\InsertKeyParam $insert_key_param Parameter (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsert'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OpenAPI\Client\Model\Key
     */
    public function keysInsert($insert_key_param, string $contentType = self::contentTypes['keysInsert'][0])
    {
        list($response) = $this->keysInsertWithHttpInfo($insert_key_param, $contentType);
        return $response;
    }

    /**
     * Operation keysInsertWithHttpInfo
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\InsertKeyParam $insert_key_param Parameter (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsert'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OpenAPI\Client\Model\Key, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysInsertWithHttpInfo($insert_key_param, string $contentType = self::contentTypes['keysInsert'][0])
    {
        $request = $this->keysInsertRequest($insert_key_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\OpenAPI\Client\Model\Key' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OpenAPI\Client\Model\Key' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OpenAPI\Client\Model\Key', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\OpenAPI\Client\Model\Key';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OpenAPI\Client\Model\Key',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation keysInsertAsync
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\InsertKeyParam $insert_key_param Parameter (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsert'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysInsertAsync($insert_key_param, string $contentType = self::contentTypes['keysInsert'][0])
    {
        return $this->keysInsertAsyncWithHttpInfo($insert_key_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysInsertAsyncWithHttpInfo
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\InsertKeyParam $insert_key_param Parameter (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsert'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysInsertAsyncWithHttpInfo($insert_key_param, string $contentType = self::contentTypes['keysInsert'][0])
    {
        $returnType = '\OpenAPI\Client\Model\Key';
        $request = $this->keysInsertRequest($insert_key_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysInsert'
     *
     * @param  \OpenAPI\Client\Model\InsertKeyParam $insert_key_param Parameter (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsert'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysInsertRequest($insert_key_param, string $contentType = self::contentTypes['keysInsert'][0])
    {

        // verify the required parameter 'insert_key_param' is set
        if ($insert_key_param === null || (is_array($insert_key_param) && count($insert_key_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $insert_key_param when calling keysInsert'
            );
        }


        $resourcePath = '/api/v2/Keys';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;





        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($insert_key_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($insert_key_param));
            } else {
                $httpBody = $insert_key_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysInsertSecurityAccess
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\AddSecurityAccessParam $add_security_access_param add_security_access_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysInsertSecurityAccess($id, $add_security_access_param, string $contentType = self::contentTypes['keysInsertSecurityAccess'][0])
    {
        $this->keysInsertSecurityAccessWithHttpInfo($id, $add_security_access_param, $contentType);
    }

    /**
     * Operation keysInsertSecurityAccessWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\AddSecurityAccessParam $add_security_access_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertSecurityAccess'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysInsertSecurityAccessWithHttpInfo($id, $add_security_access_param, string $contentType = self::contentTypes['keysInsertSecurityAccess'][0])
    {
        $request = $this->keysInsertSecurityAccessRequest($id, $add_security_access_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysInsertSecurityAccessAsync
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\AddSecurityAccessParam $add_security_access_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysInsertSecurityAccessAsync($id, $add_security_access_param, string $contentType = self::contentTypes['keysInsertSecurityAccess'][0])
    {
        return $this->keysInsertSecurityAccessAsyncWithHttpInfo($id, $add_security_access_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysInsertSecurityAccessAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\AddSecurityAccessParam $add_security_access_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysInsertSecurityAccessAsyncWithHttpInfo($id, $add_security_access_param, string $contentType = self::contentTypes['keysInsertSecurityAccess'][0])
    {
        $returnType = '';
        $request = $this->keysInsertSecurityAccessRequest($id, $add_security_access_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysInsertSecurityAccess'
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\AddSecurityAccessParam $add_security_access_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertSecurityAccess'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysInsertSecurityAccessRequest($id, $add_security_access_param, string $contentType = self::contentTypes['keysInsertSecurityAccess'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysInsertSecurityAccess'
            );
        }

        // verify the required parameter 'add_security_access_param' is set
        if ($add_security_access_param === null || (is_array($add_security_access_param) && count($add_security_access_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $add_security_access_param when calling keysInsertSecurityAccess'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/SecurityAccesses';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($add_security_access_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($add_security_access_param));
            } else {
                $httpBody = $add_security_access_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysInsertTimeLimitTitle
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysInsertTimeLimitTitle($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysInsertTimeLimitTitle'][0])
    {
        $this->keysInsertTimeLimitTitleWithHttpInfo($id, $insert_key_time_limit_slot_param, $contentType);
    }

    /**
     * Operation keysInsertTimeLimitTitleWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysInsertTimeLimitTitleWithHttpInfo($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysInsertTimeLimitTitle'][0])
    {
        $request = $this->keysInsertTimeLimitTitleRequest($id, $insert_key_time_limit_slot_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysInsertTimeLimitTitleAsync
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysInsertTimeLimitTitleAsync($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysInsertTimeLimitTitle'][0])
    {
        return $this->keysInsertTimeLimitTitleAsyncWithHttpInfo($id, $insert_key_time_limit_slot_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysInsertTimeLimitTitleAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysInsertTimeLimitTitleAsyncWithHttpInfo($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysInsertTimeLimitTitle'][0])
    {
        $returnType = '';
        $request = $this->keysInsertTimeLimitTitleRequest($id, $insert_key_time_limit_slot_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysInsertTimeLimitTitle'
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\InsertKeyTimeLimitSlotParam $insert_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysInsertTimeLimitTitle'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysInsertTimeLimitTitleRequest($id, $insert_key_time_limit_slot_param, string $contentType = self::contentTypes['keysInsertTimeLimitTitle'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysInsertTimeLimitTitle'
            );
        }

        // verify the required parameter 'insert_key_time_limit_slot_param' is set
        if ($insert_key_time_limit_slot_param === null || (is_array($insert_key_time_limit_slot_param) && count($insert_key_time_limit_slot_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $insert_key_time_limit_slot_param when calling keysInsertTimeLimitTitle'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/TimeLimitTitles';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($insert_key_time_limit_slot_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($insert_key_time_limit_slot_param));
            } else {
                $httpBody = $insert_key_time_limit_slot_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysOrderKey
     *
     * /api/v2/Keys/{id}/Order
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysOrderKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysOrderKey($id, string $contentType = self::contentTypes['keysOrderKey'][0])
    {
        $this->keysOrderKeyWithHttpInfo($id, $contentType);
    }

    /**
     * Operation keysOrderKeyWithHttpInfo
     *
     * /api/v2/Keys/{id}/Order
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysOrderKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysOrderKeyWithHttpInfo($id, string $contentType = self::contentTypes['keysOrderKey'][0])
    {
        $request = $this->keysOrderKeyRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysOrderKeyAsync
     *
     * /api/v2/Keys/{id}/Order
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysOrderKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysOrderKeyAsync($id, string $contentType = self::contentTypes['keysOrderKey'][0])
    {
        return $this->keysOrderKeyAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysOrderKeyAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/Order
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysOrderKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysOrderKeyAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysOrderKey'][0])
    {
        $returnType = '';
        $request = $this->keysOrderKeyRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysOrderKey'
     *
     * @param  string $id Key Id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysOrderKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysOrderKeyRequest($id, string $contentType = self::contentTypes['keysOrderKey'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysOrderKey'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/Order';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysReturnKey
     *
     * /api/v2/Keys/{id}/Return
     *
     * @param  string $id id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysReturnKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysReturnKey($id, string $contentType = self::contentTypes['keysReturnKey'][0])
    {
        $this->keysReturnKeyWithHttpInfo($id, $contentType);
    }

    /**
     * Operation keysReturnKeyWithHttpInfo
     *
     * /api/v2/Keys/{id}/Return
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysReturnKey'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysReturnKeyWithHttpInfo($id, string $contentType = self::contentTypes['keysReturnKey'][0])
    {
        $request = $this->keysReturnKeyRequest($id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysReturnKeyAsync
     *
     * /api/v2/Keys/{id}/Return
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysReturnKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysReturnKeyAsync($id, string $contentType = self::contentTypes['keysReturnKey'][0])
    {
        return $this->keysReturnKeyAsyncWithHttpInfo($id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysReturnKeyAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/Return
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysReturnKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysReturnKeyAsyncWithHttpInfo($id, string $contentType = self::contentTypes['keysReturnKey'][0])
    {
        $returnType = '';
        $request = $this->keysReturnKeyRequest($id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysReturnKey'
     *
     * @param  string $id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysReturnKey'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysReturnKeyRequest($id, string $contentType = self::contentTypes['keysReturnKey'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysReturnKey'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/Return';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysSetKeyLocationReportingInAuditTrail
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id of phone key (required)
     * @param  \OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam $public_api_set_key_location_reporting_in_audit_trail_param public_api_set_key_location_reporting_in_audit_trail_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysSetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysSetKeyLocationReportingInAuditTrail($id, $public_api_set_key_location_reporting_in_audit_trail_param, string $contentType = self::contentTypes['keysSetKeyLocationReportingInAuditTrail'][0])
    {
        $this->keysSetKeyLocationReportingInAuditTrailWithHttpInfo($id, $public_api_set_key_location_reporting_in_audit_trail_param, $contentType);
    }

    /**
     * Operation keysSetKeyLocationReportingInAuditTrailWithHttpInfo
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id of phone key (required)
     * @param  \OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam $public_api_set_key_location_reporting_in_audit_trail_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysSetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysSetKeyLocationReportingInAuditTrailWithHttpInfo($id, $public_api_set_key_location_reporting_in_audit_trail_param, string $contentType = self::contentTypes['keysSetKeyLocationReportingInAuditTrail'][0])
    {
        $request = $this->keysSetKeyLocationReportingInAuditTrailRequest($id, $public_api_set_key_location_reporting_in_audit_trail_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysSetKeyLocationReportingInAuditTrailAsync
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id of phone key (required)
     * @param  \OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam $public_api_set_key_location_reporting_in_audit_trail_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysSetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysSetKeyLocationReportingInAuditTrailAsync($id, $public_api_set_key_location_reporting_in_audit_trail_param, string $contentType = self::contentTypes['keysSetKeyLocationReportingInAuditTrail'][0])
    {
        return $this->keysSetKeyLocationReportingInAuditTrailAsyncWithHttpInfo($id, $public_api_set_key_location_reporting_in_audit_trail_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysSetKeyLocationReportingInAuditTrailAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/LocationReporting
     *
     * @param  string $id Key id of phone key (required)
     * @param  \OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam $public_api_set_key_location_reporting_in_audit_trail_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysSetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysSetKeyLocationReportingInAuditTrailAsyncWithHttpInfo($id, $public_api_set_key_location_reporting_in_audit_trail_param, string $contentType = self::contentTypes['keysSetKeyLocationReportingInAuditTrail'][0])
    {
        $returnType = '';
        $request = $this->keysSetKeyLocationReportingInAuditTrailRequest($id, $public_api_set_key_location_reporting_in_audit_trail_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysSetKeyLocationReportingInAuditTrail'
     *
     * @param  string $id Key id of phone key (required)
     * @param  \OpenAPI\Client\Model\PublicApiSetKeyLocationReportingInAuditTrailParam $public_api_set_key_location_reporting_in_audit_trail_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysSetKeyLocationReportingInAuditTrail'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysSetKeyLocationReportingInAuditTrailRequest($id, $public_api_set_key_location_reporting_in_audit_trail_param, string $contentType = self::contentTypes['keysSetKeyLocationReportingInAuditTrail'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysSetKeyLocationReportingInAuditTrail'
            );
        }

        // verify the required parameter 'public_api_set_key_location_reporting_in_audit_trail_param' is set
        if ($public_api_set_key_location_reporting_in_audit_trail_param === null || (is_array($public_api_set_key_location_reporting_in_audit_trail_param) && count($public_api_set_key_location_reporting_in_audit_trail_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $public_api_set_key_location_reporting_in_audit_trail_param when calling keysSetKeyLocationReportingInAuditTrail'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/LocationReporting';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($public_api_set_key_location_reporting_in_audit_trail_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($public_api_set_key_location_reporting_in_audit_trail_param));
            } else {
                $httpBody = $public_api_set_key_location_reporting_in_audit_trail_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysUpdate
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\UpdateKeyParam $update_key_param Parameter (required)
     * @param  bool $update_version_code update_version_code (optional, default to false)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdate'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysUpdate($update_key_param, $update_version_code = false, string $contentType = self::contentTypes['keysUpdate'][0])
    {
        $this->keysUpdateWithHttpInfo($update_key_param, $update_version_code, $contentType);
    }

    /**
     * Operation keysUpdateWithHttpInfo
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\UpdateKeyParam $update_key_param Parameter (required)
     * @param  bool $update_version_code (optional, default to false)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdate'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysUpdateWithHttpInfo($update_key_param, $update_version_code = false, string $contentType = self::contentTypes['keysUpdate'][0])
    {
        $request = $this->keysUpdateRequest($update_key_param, $update_version_code, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysUpdateAsync
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\UpdateKeyParam $update_key_param Parameter (required)
     * @param  bool $update_version_code (optional, default to false)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateAsync($update_key_param, $update_version_code = false, string $contentType = self::contentTypes['keysUpdate'][0])
    {
        return $this->keysUpdateAsyncWithHttpInfo($update_key_param, $update_version_code, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysUpdateAsyncWithHttpInfo
     *
     * /api/v2/Keys
     *
     * @param  \OpenAPI\Client\Model\UpdateKeyParam $update_key_param Parameter (required)
     * @param  bool $update_version_code (optional, default to false)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateAsyncWithHttpInfo($update_key_param, $update_version_code = false, string $contentType = self::contentTypes['keysUpdate'][0])
    {
        $returnType = '';
        $request = $this->keysUpdateRequest($update_key_param, $update_version_code, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysUpdate'
     *
     * @param  \OpenAPI\Client\Model\UpdateKeyParam $update_key_param Parameter (required)
     * @param  bool $update_version_code (optional, default to false)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysUpdateRequest($update_key_param, $update_version_code = false, string $contentType = self::contentTypes['keysUpdate'][0])
    {

        // verify the required parameter 'update_key_param' is set
        if ($update_key_param === null || (is_array($update_key_param) && count($update_key_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $update_key_param when calling keysUpdate'
            );
        }



        $resourcePath = '/api/v2/Keys';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $update_version_code,
            'updateVersionCode', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);




        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($update_key_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($update_key_param));
            } else {
                $httpBody = $update_key_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysUpdateMainZone
     *
     * /api/v2/Keys/{id}/UpdateMainZone
     *
     * @param  string $id id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyMainZoneParam $update_key_main_zone_param update_key_main_zone_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateMainZone'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysUpdateMainZone($id, $update_key_main_zone_param, string $contentType = self::contentTypes['keysUpdateMainZone'][0])
    {
        $this->keysUpdateMainZoneWithHttpInfo($id, $update_key_main_zone_param, $contentType);
    }

    /**
     * Operation keysUpdateMainZoneWithHttpInfo
     *
     * /api/v2/Keys/{id}/UpdateMainZone
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyMainZoneParam $update_key_main_zone_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateMainZone'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysUpdateMainZoneWithHttpInfo($id, $update_key_main_zone_param, string $contentType = self::contentTypes['keysUpdateMainZone'][0])
    {
        $request = $this->keysUpdateMainZoneRequest($id, $update_key_main_zone_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysUpdateMainZoneAsync
     *
     * /api/v2/Keys/{id}/UpdateMainZone
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyMainZoneParam $update_key_main_zone_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateMainZone'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateMainZoneAsync($id, $update_key_main_zone_param, string $contentType = self::contentTypes['keysUpdateMainZone'][0])
    {
        return $this->keysUpdateMainZoneAsyncWithHttpInfo($id, $update_key_main_zone_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysUpdateMainZoneAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/UpdateMainZone
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyMainZoneParam $update_key_main_zone_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateMainZone'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateMainZoneAsyncWithHttpInfo($id, $update_key_main_zone_param, string $contentType = self::contentTypes['keysUpdateMainZone'][0])
    {
        $returnType = '';
        $request = $this->keysUpdateMainZoneRequest($id, $update_key_main_zone_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysUpdateMainZone'
     *
     * @param  string $id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyMainZoneParam $update_key_main_zone_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateMainZone'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysUpdateMainZoneRequest($id, $update_key_main_zone_param, string $contentType = self::contentTypes['keysUpdateMainZone'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysUpdateMainZone'
            );
        }

        // verify the required parameter 'update_key_main_zone_param' is set
        if ($update_key_main_zone_param === null || (is_array($update_key_main_zone_param) && count($update_key_main_zone_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $update_key_main_zone_param when calling keysUpdateMainZone'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/UpdateMainZone';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($update_key_main_zone_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($update_key_main_zone_param));
            } else {
                $httpBody = $update_key_main_zone_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysUpdateSecurityAccesses
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeySecurityAccessesParam $update_key_security_accesses_param update_key_security_accesses_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysUpdateSecurityAccesses($id, $update_key_security_accesses_param, string $contentType = self::contentTypes['keysUpdateSecurityAccesses'][0])
    {
        $this->keysUpdateSecurityAccessesWithHttpInfo($id, $update_key_security_accesses_param, $contentType);
    }

    /**
     * Operation keysUpdateSecurityAccessesWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeySecurityAccessesParam $update_key_security_accesses_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysUpdateSecurityAccessesWithHttpInfo($id, $update_key_security_accesses_param, string $contentType = self::contentTypes['keysUpdateSecurityAccesses'][0])
    {
        $request = $this->keysUpdateSecurityAccessesRequest($id, $update_key_security_accesses_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysUpdateSecurityAccessesAsync
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeySecurityAccessesParam $update_key_security_accesses_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateSecurityAccessesAsync($id, $update_key_security_accesses_param, string $contentType = self::contentTypes['keysUpdateSecurityAccesses'][0])
    {
        return $this->keysUpdateSecurityAccessesAsyncWithHttpInfo($id, $update_key_security_accesses_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysUpdateSecurityAccessesAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/SecurityAccesses
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeySecurityAccessesParam $update_key_security_accesses_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateSecurityAccessesAsyncWithHttpInfo($id, $update_key_security_accesses_param, string $contentType = self::contentTypes['keysUpdateSecurityAccesses'][0])
    {
        $returnType = '';
        $request = $this->keysUpdateSecurityAccessesRequest($id, $update_key_security_accesses_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysUpdateSecurityAccesses'
     *
     * @param  string $id Key id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeySecurityAccessesParam $update_key_security_accesses_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateSecurityAccesses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysUpdateSecurityAccessesRequest($id, $update_key_security_accesses_param, string $contentType = self::contentTypes['keysUpdateSecurityAccesses'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysUpdateSecurityAccesses'
            );
        }

        // verify the required parameter 'update_key_security_accesses_param' is set
        if ($update_key_security_accesses_param === null || (is_array($update_key_security_accesses_param) && count($update_key_security_accesses_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $update_key_security_accesses_param when calling keysUpdateSecurityAccesses'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/SecurityAccesses';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($update_key_security_accesses_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($update_key_security_accesses_param));
            } else {
                $httpBody = $update_key_security_accesses_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation keysUpdateTimeLimit
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam $update_key_time_limit_slot_param update_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateTimeLimit'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return void
     */
    public function keysUpdateTimeLimit($id, $time_limit_title_id, $update_key_time_limit_slot_param, string $contentType = self::contentTypes['keysUpdateTimeLimit'][0])
    {
        $this->keysUpdateTimeLimitWithHttpInfo($id, $time_limit_title_id, $update_key_time_limit_slot_param, $contentType);
    }

    /**
     * Operation keysUpdateTimeLimitWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam $update_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateTimeLimit'] to see the possible values for this operation
     *
     * @throws \OpenAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function keysUpdateTimeLimitWithHttpInfo($id, $time_limit_title_id, $update_key_time_limit_slot_param, string $contentType = self::contentTypes['keysUpdateTimeLimit'][0])
    {
        $request = $this->keysUpdateTimeLimitRequest($id, $time_limit_title_id, $update_key_time_limit_slot_param, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation keysUpdateTimeLimitAsync
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam $update_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateTimeLimitAsync($id, $time_limit_title_id, $update_key_time_limit_slot_param, string $contentType = self::contentTypes['keysUpdateTimeLimit'][0])
    {
        return $this->keysUpdateTimeLimitAsyncWithHttpInfo($id, $time_limit_title_id, $update_key_time_limit_slot_param, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation keysUpdateTimeLimitAsyncWithHttpInfo
     *
     * /api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam $update_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function keysUpdateTimeLimitAsyncWithHttpInfo($id, $time_limit_title_id, $update_key_time_limit_slot_param, string $contentType = self::contentTypes['keysUpdateTimeLimit'][0])
    {
        $returnType = '';
        $request = $this->keysUpdateTimeLimitRequest($id, $time_limit_title_id, $update_key_time_limit_slot_param, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'keysUpdateTimeLimit'
     *
     * @param  string $id Key id (required)
     * @param  string $time_limit_title_id Time limit title id (required)
     * @param  \OpenAPI\Client\Model\UpdateKeyTimeLimitSlotParam $update_key_time_limit_slot_param (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['keysUpdateTimeLimit'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function keysUpdateTimeLimitRequest($id, $time_limit_title_id, $update_key_time_limit_slot_param, string $contentType = self::contentTypes['keysUpdateTimeLimit'][0])
    {

        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling keysUpdateTimeLimit'
            );
        }

        // verify the required parameter 'time_limit_title_id' is set
        if ($time_limit_title_id === null || (is_array($time_limit_title_id) && count($time_limit_title_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $time_limit_title_id when calling keysUpdateTimeLimit'
            );
        }

        // verify the required parameter 'update_key_time_limit_slot_param' is set
        if ($update_key_time_limit_slot_param === null || (is_array($update_key_time_limit_slot_param) && count($update_key_time_limit_slot_param) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $update_key_time_limit_slot_param when calling keysUpdateTimeLimit'
            );
        }


        $resourcePath = '/api/v2/Keys/{id}/TimeLimitTitles/{timeLimitTitleId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }
        // path params
        if ($time_limit_title_id !== null) {
            $resourcePath = str_replace(
                '{' . 'timeLimitTitleId' . '}',
                ObjectSerializer::toPathValue($time_limit_title_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            [],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($update_key_time_limit_slot_param)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($update_key_time_limit_slot_param));
            } else {
                $httpBody = $update_key_time_limit_slot_param;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
