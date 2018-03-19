<?php
namespace Sample\Controller;


use Slimvc\Core\Controller;

class IndexController extends Controller
{
    /**
     * Default index action
     */
    public function actionIndex()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/dashboard.phtml");
    }

    public function actionSigninPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/signin.phtml");
    }

    public function actionSignupPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/signup.phtml");
    }

    public function actionSignoutPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/signout.phtml");
    }

    public function actionChkpwdPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/chkpwd.phtml");
    }

    public function actionChangepwdPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/changepwd.phtml");
    }

    public function actionSuccessmessagePage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/successmessage.phtml");
    }

    public function actionMapPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/maps.phtml");
    }

    public function actionIDCancellationPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/idcancellation.phtml");
    }

    public function actionMailPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/forgottenmail.phtml");
    }

    public function actionVerificationPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/verification.phtml");
    }

    public function actionFchangepwdPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/fchangepwd.phtml");
    }

    public function actionCheckemailPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/chkemail.phtml");
    }

    public function actionRealtimeHeartratePage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/realtimeheartrate.phtml");
    }

    public function actionRealtimeAQIDataPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/realtimeaqi.phtml");
    }

    public function actionHistoricalHeartratePage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/historicalheartrate.phtml");
    }

    public function actionHistoricalAQIDataPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/historicalaqi.phtml");
    }

    public function actionChkpwdprofilePage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/chkpwdprofile.phtml");
    }

    public function actionAboutusPage()
    {
        $this->getApp()->contentType('text/html');

        $this->render("web/aboutus.phtml");
    }
}
