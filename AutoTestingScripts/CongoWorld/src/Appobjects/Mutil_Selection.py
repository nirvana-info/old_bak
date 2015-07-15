'''
Created on 2010-10-9

@author: christie.duan
'''
import PublicFunctions


def Year(self,yearOption):
    PublicFunctions.my_wait_element(self,"//div[@id='LayoutColumn1']/div[2]/div[1]/div[1]/ul[1]/li[2]/img")
    if PublicFunctions.my_wait_element(self,"//input[@value=\'%s\']" %yearOption) is False:
        self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[1]/div[1]/ul[1]/li[2]/img")   
    PublicFunctions.my_wait_element(self,"//input[@value=\'%s\']" %yearOption)
    self.selenium.click("//input[@value=\'%s\']" %yearOption)     
#    PublicFunctions.my_wait_element(self, "//a[@id='searchyear']/span")
#    self.selenium.click("//a[@id='searchyear']/span")
#    self.selenium.click(yearOption)
#    self.selenium.click("//div[@id='mmyform_year']/div/div/ul/li[3]/a")

    
def Make(self,make):
    PublicFunctions.my_wait_element(self,"//div[@id='LayoutColumn1']/div[2]/div[1]/div[2]/ul[1]/li[2]/img")
    if PublicFunctions.my_wait_element(self,"//input[@value=\'%s\']" %make) is False:
        self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[1]/div[2]/ul[1]/li[2]/img")   
    self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[1]/div[2]/ul[1]/li[2]/img")   
    PublicFunctions.my_wait_element(self,"//input[@value=\'%s\']" %make)
    self.selenium.click("//input[@value=\'%s\']" %make)     
#    FunctionCommon.my_wait_element(self,"mmy_make")  
#    self.selenium.click("mmy_make")
#    FunctionCommon.my_wait_element(self,"make_more")
#    self.selenium.click("link="+make)
#    FunctionCommon.my_wait_title(self,make)
    
    
def Categories_QP(self,value):
    PublicFunctions.my_wait_element(self,"//div[@id='LayoutColumn1']/div[2]/div[3]/ul[1]/li[2]/img")
    if PublicFunctions.my_wait_element(self,"//input[@name=\'%s\']" %value) is False:
        self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[3]/ul[1]/li[2]/img")     
    self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[3]/ul[1]/li[2]/img")
    PublicFunctions.my_wait_element(self,"//input[@name=\'%s\']" %value)
    self.selenium.click("//input[@name=\'%s\']" %value)
#    PublicFunctions.my_wait_element(self,"//input[@name='category[]' and @value=\'%s\']" % value)
#    self.selenium.click("//input[@name='category[]' and @value=\'%s\']" % value)
    
def SubCategories_options(self,catesValue,subcatesValue):
     sel.click("//ul[@id='FavBrands']/li[%s]/a[1]/img" % catesValue)
     sel.click("//input[@value=\'%s\']" % subcatesValue)

def SubCategories_select(self, subcatesName):
    PublicFunctions.my_wait_element(self,"link=%s" % subcatesName)
    self.selenium.click("link=%s" % subcatesName)    
    
def Brand(self,value):
    PublicFunctions.my_wait_element(self,"//div[@id='LayoutColumn1']/div[2]/div[2]/ul[1]/li[2]/img")
    if PublicFunctions.my_wait_element(self,"//input[@name=\'%s\']" %value) is False:
        self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[2]/ul[1]/li[2]/img") 
    self.selenium.click("//div[@id='LayoutColumn1']/div[2]/div[2]/ul[1]/li[2]/img")
    PublicFunctions.my_wait_element(self,"//input[@name=\'%s\']" %value)
    self.selenium.click("//input[@name=\'%s\']" %value)
    
#    self.selenium.click("//input[@name='brand[]' and @value=\'%s\']" % value)

def Series_options(self,series):
    PublicFunctions.my_wait_element(self,"link=%s" % series)
    self.selenium.click("link=%s" % series)



def Products_ViewDetail(self):
#    PublicFunctions.my_wait_element(self,("//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input"))
#    self.selenium.click("//div[@id='ProductDetails']/div/form/div/dl[2]/dd/div/input")
    PublicFunctions.my_wait_element(self,"//img[contains(@src,'/templates/default/images/view.gif')]") 
    self.selenium.click("//img[contains(@src,'/templates/default/images/view.gif')]")                         
    
def couponcode(self,value):
    FunctionCommon.my_wait_element(self,"couponcode")
    self.selenium.type("couponcode", value)
    self.selenium.click("//div[@id='CartContent']/div/div[1]/table/thead[1]/tr/td[2]/input[2]")
    
    
    
    