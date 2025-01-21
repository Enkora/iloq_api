<?php
/**
 * NetworkModule
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
 * NetworkModule Class Doc Comment
 *
 * @category Class
 * @description Network module
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class NetworkModule implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'NetworkModule';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'adapter_nr' => 'string',
        'adapter_version' => 'string',
        'allowed_ip' => 'string',
        'allowed_socket_request' => '\OpenAPI\Client\Model\NetworkModuleAllowedSocketRequest',
        'board_hot_spot' => 'int',
        'board_settings' => 'string',
        'calendar_data_modified_date' => '\DateTime',
        'calendar_data_received_date' => '\DateTime',
        'calendar_data_state' => '\OpenAPI\Client\Model\NetworkModuleCalendarDataState',
        'description' => 'string',
        'device_limit_count' => 'int',
        'f_prog_key_id' => 'string',
        'ip_address' => 'string',
        'ip_address_user_defined' => 'string',
        'key_id' => 'string',
        'key_prog_packet_list_received_date' => '\DateTime',
        'license_mode' => 'int',
        'location_picture_id' => 'string',
        'location_point_attributes' => 'string',
        'location_point_x' => 'float',
        'location_point_y' => 'float',
        'online_connection_date' => '\DateTime',
        'online_key' => 'string',
        'online_mac_address' => 'string',
        'online_software_version' => 'string',
        'port' => 'int',
        'port_user_defined' => 'int',
        'real_estate_id' => 'string',
        'request_type' => '\OpenAPI\Client\Model\NetworkModuleRequestType',
        'request_type_info' => 'string',
        'state' => '\OpenAPI\Client\Model\NetworkModuleState',
        'state_mask' => '\OpenAPI\Client\Model\NetworkModuleStateMask',
        'type' => '\OpenAPI\Client\Model\NetworkModuleType',
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
        'adapter_nr' => null,
        'adapter_version' => null,
        'allowed_ip' => null,
        'allowed_socket_request' => null,
        'board_hot_spot' => null,
        'board_settings' => null,
        'calendar_data_modified_date' => 'date-time',
        'calendar_data_received_date' => 'date-time',
        'calendar_data_state' => null,
        'description' => null,
        'device_limit_count' => 'int32',
        'f_prog_key_id' => 'guid',
        'ip_address' => null,
        'ip_address_user_defined' => null,
        'key_id' => null,
        'key_prog_packet_list_received_date' => 'date-time',
        'license_mode' => null,
        'location_picture_id' => 'guid',
        'location_point_attributes' => null,
        'location_point_x' => 'double',
        'location_point_y' => 'double',
        'online_connection_date' => 'date-time',
        'online_key' => 'guid',
        'online_mac_address' => null,
        'online_software_version' => null,
        'port' => null,
        'port_user_defined' => null,
        'real_estate_id' => 'guid',
        'request_type' => null,
        'request_type_info' => null,
        'state' => null,
        'state_mask' => null,
        'type' => null,
        'zone_id' => 'guid'
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'adapter_nr' => true,
        'adapter_version' => true,
        'allowed_ip' => true,
        'allowed_socket_request' => false,
        'board_hot_spot' => false,
        'board_settings' => true,
        'calendar_data_modified_date' => true,
        'calendar_data_received_date' => true,
        'calendar_data_state' => false,
        'description' => true,
        'device_limit_count' => false,
        'f_prog_key_id' => false,
        'ip_address' => true,
        'ip_address_user_defined' => true,
        'key_id' => true,
        'key_prog_packet_list_received_date' => true,
        'license_mode' => false,
        'location_picture_id' => true,
        'location_point_attributes' => true,
        'location_point_x' => false,
        'location_point_y' => false,
        'online_connection_date' => true,
        'online_key' => true,
        'online_mac_address' => true,
        'online_software_version' => true,
        'port' => false,
        'port_user_defined' => true,
        'real_estate_id' => true,
        'request_type' => false,
        'request_type_info' => true,
        'state' => false,
        'state_mask' => false,
        'type' => false,
        'zone_id' => true
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
        'adapter_nr' => 'AdapterNr',
        'adapter_version' => 'AdapterVersion',
        'allowed_ip' => 'AllowedIP',
        'allowed_socket_request' => 'AllowedSocketRequest',
        'board_hot_spot' => 'BoardHotSpot',
        'board_settings' => 'BoardSettings',
        'calendar_data_modified_date' => 'CalendarDataModifiedDate',
        'calendar_data_received_date' => 'CalendarDataReceivedDate',
        'calendar_data_state' => 'CalendarDataState',
        'description' => 'Description',
        'device_limit_count' => 'DeviceLimitCount',
        'f_prog_key_id' => 'FProgKey_ID',
        'ip_address' => 'IPAddress',
        'ip_address_user_defined' => 'IPAddressUserDefined',
        'key_id' => 'KeyId',
        'key_prog_packet_list_received_date' => 'KeyProgPacketListReceivedDate',
        'license_mode' => 'LicenseMode',
        'location_picture_id' => 'LocationPicture_ID',
        'location_point_attributes' => 'LocationPointAttributes',
        'location_point_x' => 'LocationPointX',
        'location_point_y' => 'LocationPointY',
        'online_connection_date' => 'OnlineConnectionDate',
        'online_key' => 'OnlineKey',
        'online_mac_address' => 'OnlineMacAddress',
        'online_software_version' => 'OnlineSoftwareVersion',
        'port' => 'Port',
        'port_user_defined' => 'PortUserDefined',
        'real_estate_id' => 'RealEstate_ID',
        'request_type' => 'RequestType',
        'request_type_info' => 'RequestTypeInfo',
        'state' => 'State',
        'state_mask' => 'StateMask',
        'type' => 'Type',
        'zone_id' => 'Zone_ID'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'adapter_nr' => 'setAdapterNr',
        'adapter_version' => 'setAdapterVersion',
        'allowed_ip' => 'setAllowedIp',
        'allowed_socket_request' => 'setAllowedSocketRequest',
        'board_hot_spot' => 'setBoardHotSpot',
        'board_settings' => 'setBoardSettings',
        'calendar_data_modified_date' => 'setCalendarDataModifiedDate',
        'calendar_data_received_date' => 'setCalendarDataReceivedDate',
        'calendar_data_state' => 'setCalendarDataState',
        'description' => 'setDescription',
        'device_limit_count' => 'setDeviceLimitCount',
        'f_prog_key_id' => 'setFProgKeyId',
        'ip_address' => 'setIpAddress',
        'ip_address_user_defined' => 'setIpAddressUserDefined',
        'key_id' => 'setKeyId',
        'key_prog_packet_list_received_date' => 'setKeyProgPacketListReceivedDate',
        'license_mode' => 'setLicenseMode',
        'location_picture_id' => 'setLocationPictureId',
        'location_point_attributes' => 'setLocationPointAttributes',
        'location_point_x' => 'setLocationPointX',
        'location_point_y' => 'setLocationPointY',
        'online_connection_date' => 'setOnlineConnectionDate',
        'online_key' => 'setOnlineKey',
        'online_mac_address' => 'setOnlineMacAddress',
        'online_software_version' => 'setOnlineSoftwareVersion',
        'port' => 'setPort',
        'port_user_defined' => 'setPortUserDefined',
        'real_estate_id' => 'setRealEstateId',
        'request_type' => 'setRequestType',
        'request_type_info' => 'setRequestTypeInfo',
        'state' => 'setState',
        'state_mask' => 'setStateMask',
        'type' => 'setType',
        'zone_id' => 'setZoneId'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'adapter_nr' => 'getAdapterNr',
        'adapter_version' => 'getAdapterVersion',
        'allowed_ip' => 'getAllowedIp',
        'allowed_socket_request' => 'getAllowedSocketRequest',
        'board_hot_spot' => 'getBoardHotSpot',
        'board_settings' => 'getBoardSettings',
        'calendar_data_modified_date' => 'getCalendarDataModifiedDate',
        'calendar_data_received_date' => 'getCalendarDataReceivedDate',
        'calendar_data_state' => 'getCalendarDataState',
        'description' => 'getDescription',
        'device_limit_count' => 'getDeviceLimitCount',
        'f_prog_key_id' => 'getFProgKeyId',
        'ip_address' => 'getIpAddress',
        'ip_address_user_defined' => 'getIpAddressUserDefined',
        'key_id' => 'getKeyId',
        'key_prog_packet_list_received_date' => 'getKeyProgPacketListReceivedDate',
        'license_mode' => 'getLicenseMode',
        'location_picture_id' => 'getLocationPictureId',
        'location_point_attributes' => 'getLocationPointAttributes',
        'location_point_x' => 'getLocationPointX',
        'location_point_y' => 'getLocationPointY',
        'online_connection_date' => 'getOnlineConnectionDate',
        'online_key' => 'getOnlineKey',
        'online_mac_address' => 'getOnlineMacAddress',
        'online_software_version' => 'getOnlineSoftwareVersion',
        'port' => 'getPort',
        'port_user_defined' => 'getPortUserDefined',
        'real_estate_id' => 'getRealEstateId',
        'request_type' => 'getRequestType',
        'request_type_info' => 'getRequestTypeInfo',
        'state' => 'getState',
        'state_mask' => 'getStateMask',
        'type' => 'getType',
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
        $this->setIfExists('adapter_nr', $data ?? [], null);
        $this->setIfExists('adapter_version', $data ?? [], null);
        $this->setIfExists('allowed_ip', $data ?? [], null);
        $this->setIfExists('allowed_socket_request', $data ?? [], null);
        $this->setIfExists('board_hot_spot', $data ?? [], null);
        $this->setIfExists('board_settings', $data ?? [], null);
        $this->setIfExists('calendar_data_modified_date', $data ?? [], null);
        $this->setIfExists('calendar_data_received_date', $data ?? [], null);
        $this->setIfExists('calendar_data_state', $data ?? [], null);
        $this->setIfExists('description', $data ?? [], null);
        $this->setIfExists('device_limit_count', $data ?? [], null);
        $this->setIfExists('f_prog_key_id', $data ?? [], null);
        $this->setIfExists('ip_address', $data ?? [], null);
        $this->setIfExists('ip_address_user_defined', $data ?? [], null);
        $this->setIfExists('key_id', $data ?? [], null);
        $this->setIfExists('key_prog_packet_list_received_date', $data ?? [], null);
        $this->setIfExists('license_mode', $data ?? [], null);
        $this->setIfExists('location_picture_id', $data ?? [], null);
        $this->setIfExists('location_point_attributes', $data ?? [], null);
        $this->setIfExists('location_point_x', $data ?? [], null);
        $this->setIfExists('location_point_y', $data ?? [], null);
        $this->setIfExists('online_connection_date', $data ?? [], null);
        $this->setIfExists('online_key', $data ?? [], null);
        $this->setIfExists('online_mac_address', $data ?? [], null);
        $this->setIfExists('online_software_version', $data ?? [], null);
        $this->setIfExists('port', $data ?? [], null);
        $this->setIfExists('port_user_defined', $data ?? [], null);
        $this->setIfExists('real_estate_id', $data ?? [], null);
        $this->setIfExists('request_type', $data ?? [], null);
        $this->setIfExists('request_type_info', $data ?? [], null);
        $this->setIfExists('state', $data ?? [], null);
        $this->setIfExists('state_mask', $data ?? [], null);
        $this->setIfExists('type', $data ?? [], null);
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
     * Gets adapter_nr
     *
     * @return string|null
     */
    public function getAdapterNr()
    {
        return $this->container['adapter_nr'];
    }

    /**
     * Sets adapter_nr
     *
     * @param string|null $adapter_nr Adapter number
     *
     * @return self
     */
    public function setAdapterNr($adapter_nr)
    {
        if (is_null($adapter_nr)) {
            array_push($this->openAPINullablesSetToNull, 'adapter_nr');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('adapter_nr', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['adapter_nr'] = $adapter_nr;

        return $this;
    }

    /**
     * Gets adapter_version
     *
     * @return string|null
     */
    public function getAdapterVersion()
    {
        return $this->container['adapter_version'];
    }

    /**
     * Sets adapter_version
     *
     * @param string|null $adapter_version Adapter version
     *
     * @return self
     */
    public function setAdapterVersion($adapter_version)
    {
        if (is_null($adapter_version)) {
            array_push($this->openAPINullablesSetToNull, 'adapter_version');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('adapter_version', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['adapter_version'] = $adapter_version;

        return $this;
    }

    /**
     * Gets allowed_ip
     *
     * @return string|null
     */
    public function getAllowedIp()
    {
        return $this->container['allowed_ip'];
    }

    /**
     * Sets allowed_ip
     *
     * @param string|null $allowed_ip Allowed IP
     *
     * @return self
     */
    public function setAllowedIp($allowed_ip)
    {
        if (is_null($allowed_ip)) {
            array_push($this->openAPINullablesSetToNull, 'allowed_ip');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('allowed_ip', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['allowed_ip'] = $allowed_ip;

        return $this;
    }

    /**
     * Gets allowed_socket_request
     *
     * @return \OpenAPI\Client\Model\NetworkModuleAllowedSocketRequest|null
     */
    public function getAllowedSocketRequest()
    {
        return $this->container['allowed_socket_request'];
    }

    /**
     * Sets allowed_socket_request
     *
     * @param \OpenAPI\Client\Model\NetworkModuleAllowedSocketRequest|null $allowed_socket_request allowed_socket_request
     *
     * @return self
     */
    public function setAllowedSocketRequest($allowed_socket_request)
    {
        if (is_null($allowed_socket_request)) {
            throw new \InvalidArgumentException('non-nullable allowed_socket_request cannot be null');
        }
        $this->container['allowed_socket_request'] = $allowed_socket_request;

        return $this;
    }

    /**
     * Gets board_hot_spot
     *
     * @return int|null
     */
    public function getBoardHotSpot()
    {
        return $this->container['board_hot_spot'];
    }

    /**
     * Sets board_hot_spot
     *
     * @param int|null $board_hot_spot Board hot spot
     *
     * @return self
     */
    public function setBoardHotSpot($board_hot_spot)
    {
        if (is_null($board_hot_spot)) {
            throw new \InvalidArgumentException('non-nullable board_hot_spot cannot be null');
        }
        $this->container['board_hot_spot'] = $board_hot_spot;

        return $this;
    }

    /**
     * Gets board_settings
     *
     * @return string|null
     */
    public function getBoardSettings()
    {
        return $this->container['board_settings'];
    }

    /**
     * Sets board_settings
     *
     * @param string|null $board_settings Board settings
     *
     * @return self
     */
    public function setBoardSettings($board_settings)
    {
        if (is_null($board_settings)) {
            array_push($this->openAPINullablesSetToNull, 'board_settings');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('board_settings', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['board_settings'] = $board_settings;

        return $this;
    }

    /**
     * Gets calendar_data_modified_date
     *
     * @return \DateTime|null
     */
    public function getCalendarDataModifiedDate()
    {
        return $this->container['calendar_data_modified_date'];
    }

    /**
     * Sets calendar_data_modified_date
     *
     * @param \DateTime|null $calendar_data_modified_date Date when calendar data was modified
     *
     * @return self
     */
    public function setCalendarDataModifiedDate($calendar_data_modified_date)
    {
        if (is_null($calendar_data_modified_date)) {
            array_push($this->openAPINullablesSetToNull, 'calendar_data_modified_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('calendar_data_modified_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['calendar_data_modified_date'] = $calendar_data_modified_date;

        return $this;
    }

    /**
     * Gets calendar_data_received_date
     *
     * @return \DateTime|null
     */
    public function getCalendarDataReceivedDate()
    {
        return $this->container['calendar_data_received_date'];
    }

    /**
     * Sets calendar_data_received_date
     *
     * @param \DateTime|null $calendar_data_received_date Date when calendar data was received
     *
     * @return self
     */
    public function setCalendarDataReceivedDate($calendar_data_received_date)
    {
        if (is_null($calendar_data_received_date)) {
            array_push($this->openAPINullablesSetToNull, 'calendar_data_received_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('calendar_data_received_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['calendar_data_received_date'] = $calendar_data_received_date;

        return $this;
    }

    /**
     * Gets calendar_data_state
     *
     * @return \OpenAPI\Client\Model\NetworkModuleCalendarDataState|null
     */
    public function getCalendarDataState()
    {
        return $this->container['calendar_data_state'];
    }

    /**
     * Sets calendar_data_state
     *
     * @param \OpenAPI\Client\Model\NetworkModuleCalendarDataState|null $calendar_data_state calendar_data_state
     *
     * @return self
     */
    public function setCalendarDataState($calendar_data_state)
    {
        if (is_null($calendar_data_state)) {
            throw new \InvalidArgumentException('non-nullable calendar_data_state cannot be null');
        }
        $this->container['calendar_data_state'] = $calendar_data_state;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string|null $description Description
     *
     * @return self
     */
    public function setDescription($description)
    {
        if (is_null($description)) {
            array_push($this->openAPINullablesSetToNull, 'description');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('description', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets device_limit_count
     *
     * @return int|null
     */
    public function getDeviceLimitCount()
    {
        return $this->container['device_limit_count'];
    }

    /**
     * Sets device_limit_count
     *
     * @param int|null $device_limit_count Device limit count
     *
     * @return self
     */
    public function setDeviceLimitCount($device_limit_count)
    {
        if (is_null($device_limit_count)) {
            throw new \InvalidArgumentException('non-nullable device_limit_count cannot be null');
        }
        $this->container['device_limit_count'] = $device_limit_count;

        return $this;
    }

    /**
     * Gets f_prog_key_id
     *
     * @return string|null
     */
    public function getFProgKeyId()
    {
        return $this->container['f_prog_key_id'];
    }

    /**
     * Sets f_prog_key_id
     *
     * @param string|null $f_prog_key_id Network module ID
     *
     * @return self
     */
    public function setFProgKeyId($f_prog_key_id)
    {
        if (is_null($f_prog_key_id)) {
            throw new \InvalidArgumentException('non-nullable f_prog_key_id cannot be null');
        }
        $this->container['f_prog_key_id'] = $f_prog_key_id;

        return $this;
    }

    /**
     * Gets ip_address
     *
     * @return string|null
     */
    public function getIpAddress()
    {
        return $this->container['ip_address'];
    }

    /**
     * Sets ip_address
     *
     * @param string|null $ip_address Network module's ip address
     *
     * @return self
     */
    public function setIpAddress($ip_address)
    {
        if (is_null($ip_address)) {
            array_push($this->openAPINullablesSetToNull, 'ip_address');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('ip_address', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['ip_address'] = $ip_address;

        return $this;
    }

    /**
     * Gets ip_address_user_defined
     *
     * @return string|null
     */
    public function getIpAddressUserDefined()
    {
        return $this->container['ip_address_user_defined'];
    }

    /**
     * Sets ip_address_user_defined
     *
     * @param string|null $ip_address_user_defined Network module's ip address if user has defined it.
     *
     * @return self
     */
    public function setIpAddressUserDefined($ip_address_user_defined)
    {
        if (is_null($ip_address_user_defined)) {
            array_push($this->openAPINullablesSetToNull, 'ip_address_user_defined');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('ip_address_user_defined', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['ip_address_user_defined'] = $ip_address_user_defined;

        return $this;
    }

    /**
     * Gets key_id
     *
     * @return string|null
     */
    public function getKeyId()
    {
        return $this->container['key_id'];
    }

    /**
     * Sets key_id
     *
     * @param string|null $key_id Key id
     *
     * @return self
     */
    public function setKeyId($key_id)
    {
        if (is_null($key_id)) {
            array_push($this->openAPINullablesSetToNull, 'key_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('key_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['key_id'] = $key_id;

        return $this;
    }

    /**
     * Gets key_prog_packet_list_received_date
     *
     * @return \DateTime|null
     */
    public function getKeyProgPacketListReceivedDate()
    {
        return $this->container['key_prog_packet_list_received_date'];
    }

    /**
     * Sets key_prog_packet_list_received_date
     *
     * @param \DateTime|null $key_prog_packet_list_received_date Programming packet list received date
     *
     * @return self
     */
    public function setKeyProgPacketListReceivedDate($key_prog_packet_list_received_date)
    {
        if (is_null($key_prog_packet_list_received_date)) {
            array_push($this->openAPINullablesSetToNull, 'key_prog_packet_list_received_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('key_prog_packet_list_received_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['key_prog_packet_list_received_date'] = $key_prog_packet_list_received_date;

        return $this;
    }

    /**
     * Gets license_mode
     *
     * @return int|null
     */
    public function getLicenseMode()
    {
        return $this->container['license_mode'];
    }

    /**
     * Sets license_mode
     *
     * @param int|null $license_mode License mode
     *
     * @return self
     */
    public function setLicenseMode($license_mode)
    {
        if (is_null($license_mode)) {
            throw new \InvalidArgumentException('non-nullable license_mode cannot be null');
        }
        $this->container['license_mode'] = $license_mode;

        return $this;
    }

    /**
     * Gets location_picture_id
     *
     * @return string|null
     */
    public function getLocationPictureId()
    {
        return $this->container['location_picture_id'];
    }

    /**
     * Sets location_picture_id
     *
     * @param string|null $location_picture_id Location picture ID
     *
     * @return self
     */
    public function setLocationPictureId($location_picture_id)
    {
        if (is_null($location_picture_id)) {
            array_push($this->openAPINullablesSetToNull, 'location_picture_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('location_picture_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['location_picture_id'] = $location_picture_id;

        return $this;
    }

    /**
     * Gets location_point_attributes
     *
     * @return string|null
     */
    public function getLocationPointAttributes()
    {
        return $this->container['location_point_attributes'];
    }

    /**
     * Sets location_point_attributes
     *
     * @param string|null $location_point_attributes Additional attributes if linked to location picture
     *
     * @return self
     */
    public function setLocationPointAttributes($location_point_attributes)
    {
        if (is_null($location_point_attributes)) {
            array_push($this->openAPINullablesSetToNull, 'location_point_attributes');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('location_point_attributes', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['location_point_attributes'] = $location_point_attributes;

        return $this;
    }

    /**
     * Gets location_point_x
     *
     * @return float|null
     */
    public function getLocationPointX()
    {
        return $this->container['location_point_x'];
    }

    /**
     * Sets location_point_x
     *
     * @param float|null $location_point_x Location point X coordinate if linked to location picture
     *
     * @return self
     */
    public function setLocationPointX($location_point_x)
    {
        if (is_null($location_point_x)) {
            throw new \InvalidArgumentException('non-nullable location_point_x cannot be null');
        }
        $this->container['location_point_x'] = $location_point_x;

        return $this;
    }

    /**
     * Gets location_point_y
     *
     * @return float|null
     */
    public function getLocationPointY()
    {
        return $this->container['location_point_y'];
    }

    /**
     * Sets location_point_y
     *
     * @param float|null $location_point_y Location point Y coordinate if linked to location picture
     *
     * @return self
     */
    public function setLocationPointY($location_point_y)
    {
        if (is_null($location_point_y)) {
            throw new \InvalidArgumentException('non-nullable location_point_y cannot be null');
        }
        $this->container['location_point_y'] = $location_point_y;

        return $this;
    }

    /**
     * Gets online_connection_date
     *
     * @return \DateTime|null
     */
    public function getOnlineConnectionDate()
    {
        return $this->container['online_connection_date'];
    }

    /**
     * Sets online_connection_date
     *
     * @param \DateTime|null $online_connection_date Connection date
     *
     * @return self
     */
    public function setOnlineConnectionDate($online_connection_date)
    {
        if (is_null($online_connection_date)) {
            array_push($this->openAPINullablesSetToNull, 'online_connection_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('online_connection_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['online_connection_date'] = $online_connection_date;

        return $this;
    }

    /**
     * Gets online_key
     *
     * @return string|null
     */
    public function getOnlineKey()
    {
        return $this->container['online_key'];
    }

    /**
     * Sets online_key
     *
     * @param string|null $online_key Key
     *
     * @return self
     */
    public function setOnlineKey($online_key)
    {
        if (is_null($online_key)) {
            array_push($this->openAPINullablesSetToNull, 'online_key');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('online_key', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['online_key'] = $online_key;

        return $this;
    }

    /**
     * Gets online_mac_address
     *
     * @return string|null
     */
    public function getOnlineMacAddress()
    {
        return $this->container['online_mac_address'];
    }

    /**
     * Sets online_mac_address
     *
     * @param string|null $online_mac_address Mac address
     *
     * @return self
     */
    public function setOnlineMacAddress($online_mac_address)
    {
        if (is_null($online_mac_address)) {
            array_push($this->openAPINullablesSetToNull, 'online_mac_address');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('online_mac_address', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['online_mac_address'] = $online_mac_address;

        return $this;
    }

    /**
     * Gets online_software_version
     *
     * @return string|null
     */
    public function getOnlineSoftwareVersion()
    {
        return $this->container['online_software_version'];
    }

    /**
     * Sets online_software_version
     *
     * @param string|null $online_software_version Software version
     *
     * @return self
     */
    public function setOnlineSoftwareVersion($online_software_version)
    {
        if (is_null($online_software_version)) {
            array_push($this->openAPINullablesSetToNull, 'online_software_version');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('online_software_version', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['online_software_version'] = $online_software_version;

        return $this;
    }

    /**
     * Gets port
     *
     * @return int|null
     */
    public function getPort()
    {
        return $this->container['port'];
    }

    /**
     * Sets port
     *
     * @param int|null $port Network module's port
     *
     * @return self
     */
    public function setPort($port)
    {
        if (is_null($port)) {
            throw new \InvalidArgumentException('non-nullable port cannot be null');
        }
        $this->container['port'] = $port;

        return $this;
    }

    /**
     * Gets port_user_defined
     *
     * @return int|null
     */
    public function getPortUserDefined()
    {
        return $this->container['port_user_defined'];
    }

    /**
     * Sets port_user_defined
     *
     * @param int|null $port_user_defined Network module's port if user has defined it.
     *
     * @return self
     */
    public function setPortUserDefined($port_user_defined)
    {
        if (is_null($port_user_defined)) {
            array_push($this->openAPINullablesSetToNull, 'port_user_defined');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('port_user_defined', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['port_user_defined'] = $port_user_defined;

        return $this;
    }

    /**
     * Gets real_estate_id
     *
     * @return string|null
     */
    public function getRealEstateId()
    {
        return $this->container['real_estate_id'];
    }

    /**
     * Sets real_estate_id
     *
     * @param string|null $real_estate_id Real estate id
     *
     * @return self
     */
    public function setRealEstateId($real_estate_id)
    {
        if (is_null($real_estate_id)) {
            array_push($this->openAPINullablesSetToNull, 'real_estate_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('real_estate_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['real_estate_id'] = $real_estate_id;

        return $this;
    }

    /**
     * Gets request_type
     *
     * @return \OpenAPI\Client\Model\NetworkModuleRequestType|null
     */
    public function getRequestType()
    {
        return $this->container['request_type'];
    }

    /**
     * Sets request_type
     *
     * @param \OpenAPI\Client\Model\NetworkModuleRequestType|null $request_type request_type
     *
     * @return self
     */
    public function setRequestType($request_type)
    {
        if (is_null($request_type)) {
            throw new \InvalidArgumentException('non-nullable request_type cannot be null');
        }
        $this->container['request_type'] = $request_type;

        return $this;
    }

    /**
     * Gets request_type_info
     *
     * @return string|null
     */
    public function getRequestTypeInfo()
    {
        return $this->container['request_type_info'];
    }

    /**
     * Sets request_type_info
     *
     * @param string|null $request_type_info Information related to request type, for example reboot time if reboot is requested
     *
     * @return self
     */
    public function setRequestTypeInfo($request_type_info)
    {
        if (is_null($request_type_info)) {
            array_push($this->openAPINullablesSetToNull, 'request_type_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('request_type_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['request_type_info'] = $request_type_info;

        return $this;
    }

    /**
     * Gets state
     *
     * @return \OpenAPI\Client\Model\NetworkModuleState|null
     * @deprecated
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     *
     * @param \OpenAPI\Client\Model\NetworkModuleState|null $state state
     *
     * @return self
     * @deprecated
     */
    public function setState($state)
    {
        if (is_null($state)) {
            throw new \InvalidArgumentException('non-nullable state cannot be null');
        }
        $this->container['state'] = $state;

        return $this;
    }

    /**
     * Gets state_mask
     *
     * @return \OpenAPI\Client\Model\NetworkModuleStateMask|null
     */
    public function getStateMask()
    {
        return $this->container['state_mask'];
    }

    /**
     * Sets state_mask
     *
     * @param \OpenAPI\Client\Model\NetworkModuleStateMask|null $state_mask state_mask
     *
     * @return self
     */
    public function setStateMask($state_mask)
    {
        if (is_null($state_mask)) {
            throw new \InvalidArgumentException('non-nullable state_mask cannot be null');
        }
        $this->container['state_mask'] = $state_mask;

        return $this;
    }

    /**
     * Gets type
     *
     * @return \OpenAPI\Client\Model\NetworkModuleType|null
     */
    public function getType()
    {
        return $this->container['type'];
    }

    /**
     * Sets type
     *
     * @param \OpenAPI\Client\Model\NetworkModuleType|null $type type
     *
     * @return self
     */
    public function setType($type)
    {
        if (is_null($type)) {
            throw new \InvalidArgumentException('non-nullable type cannot be null');
        }
        $this->container['type'] = $type;

        return $this;
    }

    /**
     * Gets zone_id
     *
     * @return string|null
     */
    public function getZoneId()
    {
        return $this->container['zone_id'];
    }

    /**
     * Sets zone_id
     *
     * @param string|null $zone_id Zone id
     *
     * @return self
     */
    public function setZoneId($zone_id)
    {
        if (is_null($zone_id)) {
            array_push($this->openAPINullablesSetToNull, 'zone_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('zone_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
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


