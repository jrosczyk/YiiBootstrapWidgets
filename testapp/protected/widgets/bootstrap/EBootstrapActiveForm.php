<?php

/*
 * Wrapper class for CActiveForm
 * Apply bootstrap style to the form
 * 
 * @author Tim Helfensdörfer <tim@visualappeal.de>
 * @version 0.3.0
 * @package bootstrap.yiiwidgets
 */
class EBootstrapActiveForm extends CActiveForm {
	/*
	 * Display a horizontal form
	 *
	 * Default: false
	 */
	public $horizontal = false;
	
	/*
	 * Error message css class
	 *
	 * Default: help-inline
	 */
	public $errorMessageCssClass = 'help-inline';
	
	/*
	 * Init the widget 
	 */
	public function init() {
		if ($this->horizontal)
			EBootstrap::mergeClass($this->htmlOptions, array('form-horizontal'));
		
		parent::init();
	}
	
	/*
	 * Execute the widget
	 */
	public function run() {
		parent::run();
	}
	
	/*
	 * Begins a control group
	 *
	 * Into the control group belongs the label, the input and the error
	 *
	 * @param CModel $model The model
	 * @param string $attribute The attribute
	 */
	public function beginControlGroup($model, $attribute) {
		$option = array();
		$option['class'] = 'control-group';
		$error = $model->getError($attribute);
		if (!empty($error))
			EBootstrap::mergeClass($option, array('error'));
		
		echo EBootstrap::openTag('div', array('class' => $option['class']));
	}
	
	/*
	 * End of the control group
	 */
	public function endControlGroup() {
		echo EBootstrap::closeTag('div');
	}
	
	/*
	 * Beginning of the controls (inputs)
	 */
	public function beginControls() {
		echo EBootstrap::openTag('div', array('class' => 'controls'));
	}
	
	/*
	 * End of the controls
	 */
	public function endControls() {
		echo EBootstrap::closeTag('div');
	}
	
	/*
	 * Beginning of the form actions
	 *
	 * Into the action sections belong all buttons like the submit or abort button
	 */
	public function beginActions() {
		echo EBootstrap::openTag('div', array('class' => 'form-actions'));
	}
	
	/*
	 * End form actions
	 */
	public function endActions() {
		echo EBootstrap::closeTag('div');
	}
	
	/*
	 * Error summary
	 *
	 * Apply bootstrap style to the error summary
	 *
	 * @param CModel $model
	 * @param string $header
	 * @param string $footer
	 * @param array $htmlOptions
	 */
	public function errorSummary($model,$header=null,$footer=null,$htmlOptions=array()) {
		$content='';
		if(!is_array($model))
			$model=array($model);
		if(isset($htmlOptions['firstError']))
		{
			$firstError=$htmlOptions['firstError'];
			unset($htmlOptions['firstError']);
		}
		else
			$firstError=false;
		foreach($model as $m)
		{
			foreach($m->getErrors() as $errors)
			{
				foreach($errors as $error)
				{
					if($error!='')
						$content.="<li>$error</li>\n";
					if($firstError)
						break;
				}
			}
		}
		if($content!=='')
		{
			if($header===null)
				$header=Yii::t('yii','Please fix the following input errors:');
			$header = EBootstrap::tag('h4', array('class' => 'alert-heading'), $header)."\n";
			
			if(!isset($htmlOptions['class']))
				$htmlOptions['class']=EBootstrap::$errorSummaryCss;
			
			EBootstrap::mergeClass($htmlOptions, array('alert', 'alert-error', 'alert-block'));
			
			return EBootstrap::tag('div',$htmlOptions,$header."\n<ul>\n$content</ul>".$footer);
		}
		else
			return '';

	}
	
	/*
	 * Returns a HTML label
	 *
	 * @param CModel $model The model
	 * @param string $attribute The attribute
	 * @param array $htmlOptions
	 */
	public function label($model,$attribute,$htmlOptions=array()) {
		if ($this->horizontal)
			EBootstrap::mergeClass($htmlOptions, array('control-label'));
		
		return EBootstrap::activeLabel($model,$attribute,$htmlOptions);
	}
	
	/*
	 * Returns an advanced HTML label
	 *
	 * @param CModel $model The model
	 * @param string $attribute The attribute
	 * @param array $htmlOptions
	 */
	public function labelEx($model,$attribute,$htmlOptions=array()) {
		if ($this->horizontal)
			EBootstrap::mergeClass($htmlOptions, array('control-label'));
		
		return EBootstrap::activeLabelEx($model,$attribute,$htmlOptions);
	}
	
	/*
	 * Returns a help block
	 *
	 * Help block can be used to improve the usabilty of a form
	 *
	 * @param string $help Help message
	 */
	public function helpBlock($help) {
		$html = EBootstrap::openTag('p', array('class' => 'help-block'));
		$html .= $help;
		$html .= EBootstrap::closeTag('p');
		
		return $html;
	}
	
	/*
	 * Render a submit buttom
	 *
	 * @param string $label Label
	 * @param array $htmlOptions
	 */
	public function submitButton($label, $htmlOptions = array()) {
		EBootstrap::mergeClass($htmlOptions, array('btn', 'btn-primary'));
		return EBootstrap::submitButton($label, $htmlOptions);
	}
}

?>