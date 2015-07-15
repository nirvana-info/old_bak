'''
Created on 2011-02-25

@author: iris chen
'''
import time


def my_wait_element(self, element):
     for i in range(80):
       try:
           if self.selenium.is_element_present(element): break
       except: pass
       time.sleep(1)
     else: self.fail("time out")   

def my_wait_title(self,text):
     for i in range(80):
       try:
           if self.selenium.get_title().find(text)<0: break
       except: pass
       time.sleep(1)
     else: self.fail("time out")

def my_wait_text_present(self,text):
     for i in range(80):
       try:
           if self.selenium.is_text_present(text): break
       except: pass
       time.sleep(1)
     else: self.fail("time out")

def my_wait_text_not_present(self,text):
     for i in range(80):
       try:
           if self.selenium.is_text_present(text) == False: break
       except: pass
       time.sleep(1)
     else: self.fail("time out")




