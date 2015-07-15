'''
Created on 2011-02-25

@author: iris chen
'''
import PublicFunctions
import time

def Year(self,yearOption):
    
    self.selenium.click("//input[@value=\'%s\']" %yearOption)

    
def Make(self,make):
    self.selenium.click("//input[@value=\'%s\']" %make)     
  
    
def Categories_QP(self,value):
    PublicFunctions.my_wait_element(self,"//input[@name=\'%s\']" %value)
    self.selenium.click("//input[@name=\'%s\']" %value)
  
def SubCategories_options(self,catesValue,subcatesValue):
    sel.click("//ul[@id='FavBrands']/li[%s]/a[1]/img" % catesValue)
    PublicFunctions.my_wait_element(self,"//input[@name=\'%s\']" %subcatesValue)
    sel.click("//input[@value=\'%s\']" % subcatesValue)

def SubCategories_select(self, subcatesName):
    PublicFunctions.my_wait_element(self,"link=%s" % subcatesName)
    self.selenium.click("link=%s" % subcatesName)    

def TwoSubCategories_select(self, alt1, alt2):
    PublicFunctions.my_wait_element(self,"//img[@alt=\'%s\']" % alt1)
    self.selenium.click("//img[@alt=\'%s\']" % alt1)
    PublicFunctions.my_wait_element(self,"//img[@alt=\'%s\']" % alt2)
    self.selenium.click("//img[@alt=\'%s\']" % alt2)
    PublicFunctions.my_wait_element(self,"//div[@id='FavoriteDivPar']/div[1]/a[1]")
    self.selenium.click("//div[@id='FavoriteDivPar']/div[1]/a[1]")

def TwoSeries_select(self,link1,link2):
    PublicFunctions.my_wait_element(self,link1)
    self.selenium.click(link1)
    PublicFunctions.my_wait_element(self,link2)
    self.selenium.click(link2)
    PublicFunctions.my_wait_element(self,"//div[@id='HomeNewProducts']/div[4]/div[1]/a[1]")
    self.selenium.click("//div[@id='HomeNewProducts']/div[4]/div[1]/a[1]")    

def SubCategories_Link(self, subcatesLink):
    PublicFunctions.my_wait_element(self,"//a[contains(@href,\'%s\')]" %subcatesLink) # "//a[@href=\'%s\']" %subcatesLink)
    self.selenium.click("//a[contains(@href,\'%s\')]" %subcatesLink)   

    
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
    PublicFunctions.my_wait_element(self,"//img[contains(@src,'/templates/default/images/view.gif')]") 
    self.selenium.click("//img[contains(@src,'/templates/default/images/view.gif')]")                         

def ProdList_AddToCart(self,qty):
    PublicFunctions.my_wait_element(self,"//img[contains(@src,'/templates/default/images/view.gif')]") 
    self.selenium.type("//input[@name='Row0']","1")
    self.selenium.click("//img[contains(@src,'/images/add-to-cart.gif')]")
    time.sleep(15)
    self.selenium.click("lang_ViewCart")
    
def couponcode(self,value):
    FunctionCommon.my_wait_element(self,"couponcode")
    self.selenium.type("couponcode", value)
    self.selenium.click("//div[@id='CartContent']/div/div[1]/table/thead[1]/tr/td[2]/input[2]")
    
    
