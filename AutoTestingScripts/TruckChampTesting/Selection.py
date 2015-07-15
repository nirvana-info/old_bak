'''
Created on 2010-10-9

@author: christie.duan
'''
import FunctionCommon


def Year(self,year):        
    FunctionCommon.my_wait_element(self, "mmy_year")
    self.selenium.click("mmy_year")
    FunctionCommon.my_wait_element(self,"year_more")
    self.selenium.click("link="+year)
    FunctionCommon.my_wait_title(self,year)
   
    
def Make(self,make):
    FunctionCommon.my_wait_element(self,"mmy_make")  
    self.selenium.click("mmy_make")
    FunctionCommon.my_wait_element(self,"make_more")
    self.selenium.click("link="+make)
    self.selenium.wait_for_page_to_load("40000")
##    FunctionCommon.my_wait_title(self,make)
    
#def Categories(self,categories):
    
    
def Categories_QP(self,categories):
    FunctionCommon.my_wait_element(self,"link="+categories)      
    self.selenium.click("link="+categories)
##    FunctionCommon.my_wait_title(self,categories)
##    FunctionCommon.my_wait_text_present(self, "Subcategories Found for")
    self.selenium.wait_for_page_to_load("40000")
        
def SubCategories_cust(self):
    FunctionCommon.my_wait_element(self,"//img[@alt='View Products']")
    self.selenium.click("//img[@alt='View Products']")

def SubCategories(self):
    FunctionCommon.my_wait_element(self,"//img[contains(@src,'/templates/default/images/viewproducts.gif')]")
    self.selenium.click("//img[contains(@src,'/templates/default/images/viewproducts.gif')]")

def SubCategories_options(self,subcategories):
    FunctionCommon.my_wait_element(self,"//img[@alt=\'%s\']" % subcategories)
    self.selenium.click("//img[@alt=\'%s\']" % subcategories)
    
def Brand(self,brand):
    FunctionCommon.my_wait_element(self,"brand_more")
    self.selenium.click("brand_more")
    FunctionCommon.my_wait_element(self,"link="+brand)
    self.selenium.click("link="+brand)
##    FunctionCommon.my_wait_text_present(self, "Series Found for")
    self.selenium.wait_for_page_to_load("40000")

def Series(self):
    FunctionCommon.my_wait_element(self,"//img[contains(@src,'/templates/default/images/viewproducts.gif')]")
    self.selenium.click("//img[contains(@src,'/templates/default/images/viewproducts.gif')]")

def Series_options(self,series):
    FunctionCommon.my_wait_element(self,"//img[@alt=\'%s\']" % series)
    self.selenium.click("//img[@alt=\'%s\']" % series)
    
def Products(self):
    FunctionCommon.my_wait_element(self,"//img[contains(@src,'/templates/default/images/view.gif')]")
    self.selenium.click("//img[contains(@src,'/templates/default/images/view.gif')]")

def smartsearch(self,searchkey):
    FunctionCommon.my_wait_element(self,"search_query")
    self.selenium.type("search_query", searchkey)
    self.selenium.click("//div[@id='SearchFormContent']/form/input[4]")
    
def couponcode(self,value):
    FunctionCommon.my_wait_element(self,"couponcode")
    self.selenium.type("couponcode", value)
    self.selenium.click("//div[@id='CartContent']/div/div[1]/table/thead[1]/tr/td[2]/input[2]")
    
    
    
    
